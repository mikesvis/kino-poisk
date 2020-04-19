<?php 
namespace TestParser;

/**
 * Класс для параметров поиска
 */
class Search
{
    /**
     * Дата по которой ищем результаты
     *
     * @var DateTime
     */
    public $date;

    /**
     * Строка запроса
     *
     * @var string
     */
    public $query;

    /**
     * Хеш строки запроса
     *
     * @var string
     */
    public $queryHash;    

    public function __construct($request)
    {
        // есть ли поле date в запросе?
        if(!isset($request['date']) || empty($request['date'])){            
            http_response_code(400);
            echo 'Укажите дату';
            exit();
        }

        // подходит ли формат даты?
        if(!preg_match("/\d{2}\.\d{2}\.\d{4}/", $request['date'])){
            http_response_code(400);
            echo 'Неверный формат даты, надо дд.мм.гггг';
            exit();
        }

        // создаем объект DateTime и сохраняем
        $this->date = (new \DateTime())->createFromFormat("d.m.Y", $request['date']);
    }
}

?>
