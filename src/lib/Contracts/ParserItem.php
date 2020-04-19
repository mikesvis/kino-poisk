<?php 
namespace TestParser\Contracts;

use TestParser\Contracts\Interfaces\ParserItemInterface;

/**
 * Общий класс результата парсинга
 */
class ParserItem
{
    public function __construct(ParserItemInterface $item)
    {
        $this->item = $item;    
    }

    /**
     * Заполнение свойств объекта полученными данными
     *
     * @param array $matches
     * @return void
     */
    public function fillFromMatches($matches)
    {
        return $this->item->fillFromMatches($matches);
    }

    /**
     * Проверка объекта на пустые данные
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->item->isEmpty();
    }
}

?>
