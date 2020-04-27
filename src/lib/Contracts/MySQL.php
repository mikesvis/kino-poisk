<?php 
namespace TestParser\Contracts;

use TestParser\Search;
use TestParser\Contracts\Interfaces\DatabaseInterface;
use TestParser\Contracts\Interfaces\ParserItemInterface;

/**
 * Класс ранилища типа Mysql
 */
class MySQL implements DatabaseInterface
{    
    /**
     * Сервер mysql
     *
     * @var string
     */
    private $server;

    /**
     * Порт mysql
     *
     * @var string
     */
    private $port;

    /**
     * Имя базы данных mysql
     *
     * @var string
     */
    private $db;

    /**
     * Пользователь mysql
     *
     * @var string
     */
    private $user;

    /**
     * Пароль mysql
     *
     * @var string
     */
    private $password;

    /**
     * Соединение
     *
     * @var Mysqli
     */
    private $connection;

    /**
     * абсолютный путь до директории с кэш файлами
     *
     * @var string
     */
    private $cacheDirectory;

    public function __construct($config)
    {
        $this->server = $config['db_server'];
        $this->port = $config['db_port'];
        $this->db = $config['db_name'];
        $this->user = $config['db_user'];
        $this->password = $config['db_password'];
        $this->cacheDirectory = $config['cache_directory'];

        $this->init();
    }

    /**
     * Подключение к хранилищу
     *
     * @return void
     */
    public function init()
    {
        $this->connection = new \mysqli($this->server, $this->user, $this->password, $this->db, $this->port); 

        if ($this->connection->connect_error)
            die('Ошибка соединения с базой');         
        
        $this->connection->set_charset("utf8mb4");
    }

    /**
     * Сохраняем массив данных в хранилище
     *
     * @param array $items
     * @return void
     */
    public function storeItems($items)
    {
        foreach ($items as $item) {
            $this->insert($item);
        }
    }

    /**
     * Добавление записи
     *
     * @param ParserItemInterface $item
     * @return void
     */
    public function insert(ParserItemInterface $item)
    {
        // сначала узнаем есть ли такой фильм в базе если есть, получаем его id
        $movieIdQuery = "SELECT id
                         FROM `movies` 
                         WHERE `name` = '".$this->connection->real_escape_string($item->name)."' 
                         AND `year` = ".(int)$item->year."
                         LIMIT 1";

        $result = $this->connection->query($movieIdQuery);

        if($result == false)
            die('Ошибка выполнения запроса');
        
        $data = mysqli_fetch_assoc($result);

        $movieId = $data['id'] ?? null;

        if(empty($movieId)) {
            // фильм не найден - добавляем новый 
            $insertNewMovieQuery = "INSERT INTO `movies` (`name`, `original`, `year`, `created_at`, `updated_at`)
                                    VALUES (
                                        '".$this->connection->real_escape_string($item->name)."', 
                                        '".$this->connection->real_escape_string($item->original)."',
                                        ".(int)$item->year.",
                                        now(),
                                        now()
                                    )";
            $this->connection->query($insertNewMovieQuery);

            $movieId = $this->connection->insert_id;
            if($movieId == 0)
                die('Не смог добавить данные в базу');
        }

        // добавляем статистику
        $insertMovieRaitingQuery = "INSERT INTO `raitings` (`movie_id`, `position`, `raiting`, `votes`, `created_at`)
                                    VALUES (
                                        ".$movieId.", 
                                        ".(int)$item->position.",
                                        ".(float)$item->raiting.",
                                        ".(int)$item->votes.",
                                        now()
                                    )";
        $this->connection->query($insertMovieRaitingQuery);

        if($this->connection->insert_id == 0)
            die('Не смог добавить данные в базу');
        
        // все хорошо, успешно добавили статистику к фильму
        return true;
        
    }

    /**
     * Создание запроса к базе в рамках драйвера хранилища
     *
     * @param Search $search
     * @return void
     */
    public function createQuery(Search $search)
    {        
        $search->query = "  SELECT r.*, m.*
                            FROM raitings r
                            RIGHT JOIN movies m ON r.movie_id = m.id
                            INNER JOIN (
                                SELECT movie_id, max(created_at) as created_at
                                FROM raitings
                                WHERE date(created_at) = '".$search->date->format('Y-m-d')."' AND position <= 10
                                GROUP BY movie_id
                            ) r1 ON r.movie_id = r1.movie_id AND r.created_at = r1.created_at
                            ORDER BY r.position
                            LIMIT 10
                        ";

        $search->queryHash = sha1($search->query);
    }

    /**
     * Закэширован ли запрос ранее? Здесь же можно добавить проверку на старость файла (для дальнейшего расширения)
     *
     * @param string $query
     * @return void
     */
    public function queryIsCached($queryHash)
    {
        
        if(file_exists($this->cacheDirectory.'/'.$queryHash))
            return true;

        return false;
    }

    /**
     * Выводим закэшироанные данные
     *
     * @param [type] $queryHash
     * @return void
     */
    public function cachedResults($queryHash)
    {
        return file_get_contents($this->cacheDirectory.'/'.$queryHash);
    }

    /**
     * Получения данных по запросу
     *
     * @param [type] $query
     * @return string строка с результами поиска в json формате
     */
    public function searchResults($query)
    {
        $result = $this->connection->query($query);

        if($result == false){
            http_response_code(400);
            echo 'Ошибка выполнения запроса';
            exit();
        }

        $data['items'] = [];

        while($row = mysqli_fetch_assoc($result)){
            $data['items'][] = $row;
        }

        if(empty($data['items'])){
            http_response_code(400);
            echo 'Данных за эту дату нет';
            exit();
        }

        $encoded = json_encode($data);

        return $encoded;

    }

    /**
     * Запись результатов в кэш
     *
     * @param string строка с данными для кэширования
     * @param string кэш строки запроса
     * @return void
     */
    public function cacheResults($jsonEncodedData, $queryHash)
    {
        file_put_contents($this->cacheDirectory.'/'.$queryHash, $jsonEncodedData);
    }

    /**
     * Закрываем соединение с хранилищем
     *  
     * @return void
     */
    public function close()
    {
        $this->connection->close();
    }
}
?>
