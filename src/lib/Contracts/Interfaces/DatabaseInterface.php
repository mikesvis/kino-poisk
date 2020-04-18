<?php 
namespace TestParser\Contracts\Interfaces;

use TestParser\Contracts\Interfaces\ParserItemInterface;

interface DatabaseInterface
{
    /**
     * Подключение к хранилищу
     *
     * @return void
     */
    public function init();

    /**
     * Запись данных
     *
     * @return void
     */
    public function storeItems($items);

    /**
     * Добавление записи
     *
     * @param ParserItemInterface $item
     * @return void
     */
    public function insert(ParserItemInterface $item);

    /**
     * Закрытие соединения с хранилищем
     *
     * @return void
     */
    public function close();
}

?>
