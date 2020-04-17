<?php 
namespace TestParser;

abstract class ParserClient
{

    protected $items = [];
    protected $pageUrl = null;
    protected $rawSource = null;

    const ERROR_SOURCE = 'Ошибка получения данных. Ответ сервера: ';
    const ERROR_NO_ITEMS = 'Результат парсинга данных пустой. Возможно изменился формат входных данных.';

    const SUCCESS = 'Данные успешно обработаны';


    public function __construct($pageUrl)
    {
        $this->pageUrl = $pageUrl;        
    }

    public function hasNoItems()
    {
        return (count($this->items) == 0) ;
    }

}

?>
