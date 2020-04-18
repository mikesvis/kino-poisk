<?php 
namespace TestParser\Contracts;

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
    private $server = 'localhost';

    /**
     * Порт mysql
     *
     * @var string
     */
    private $port = '3306';

    /**
     * Имя базы данных mysql
     *
     * @var string
     */
    private $db = 'test-parser.db';

    /**
     * Пользователь mysql
     *
     * @var string
     */
    private $user = 'root';

    /**
     * Пароль mysql
     *
     * @var string
     */
    private $password = 'password';

    /**
     * Соединение
     *
     * @var Mysqli
     */
    private $connection;

    public function __construct()
    {
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
        
        $this->connection->set_charset("utf8");
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
