<?php 
namespace TestParser\Contracts\Interfaces;

interface ParserItemInterface
{
    /**
     * Заполнение свойств объекта полученными данными
     *
     * @param array $matches
     * @return void
     */
    public function fillFromMatches($matches);

    /**
     * Проверка объекта на пустые данные
     *
     * @return boolean
     */
    public function isEmpty();
}
?>
