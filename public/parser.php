<?php
require_once('../vendor/autoload.php');
$config = parse_ini_file('../config.ini');

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
$storage = new MySQL($config);
$storage->storeItems($parser->data->items);
$storage->close();

// всё ок, завершаем
die('Данные успешно обработаны');

?>
