<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 'On');
ini_set('xdebug.var_display_max_data', -1);

require_once('../vendor/autoload.php');

use TestParser\Kinopoisk;
use TestParser\Contracts\MySQL;
use TestParser\Contracts\Parser;

// создаем парсер для кинопоиска
$client = new Kinopoisk('https://www.kinopoisk.ru/top/');

// инициализируем парсер через инъекцию
$parser = new Parser($client);

// запускаем поиск данных по ресурсу
$parser->data->findItems();

//инициализируем подключение к mysql сохраняем данные, закрываем соединение
$storage = new MySQL();
$storage->storeItems($parser->data->items);
$storage->close();

// всё ок, завершаем
die('Данные успешно обработаны');

?>
