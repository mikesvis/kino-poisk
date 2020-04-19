<?php 
namespace TestParser\Contracts\Interfaces;

interface ParserInterface
{
    /**
     * Получаем сожеджимое страницы
     *
     * @param string $pageUrl адрес страницы
     * @return string сожеджимое страницы
     */
    public function getHtml($pageUrl = '');

    /**
     * Получаем результаты парсинга и собираем их в массив
     *
     * @return ParserInterface
     */
    public function findItems();

    /**
     * Проверка на наличие результатов парсинга
     *
     * @return boolean
     */
    public function hasNoItems();
}
?>
