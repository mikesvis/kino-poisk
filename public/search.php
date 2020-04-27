<?php
require_once('../vendor/autoload.php');
$config = parse_ini_file('../config.ini');

use TestParser\Search;
use TestParser\Contracts\MySQL;

// создаем поиск
$search = new Search($_GET);

// создаем объект хранилища
$storage = new MySQL($config);

// генерируем запрос
$storage->createQuery($search);

$result = null;

// узнаем есть ли кэшированный результат поиска
if($storage->queryIsCached($search->queryHash)){
    $result = $storage->cachedResults($search->queryHash);
} else {
    // нет, кэшируем и выводим
    $result = $storage->searchResults($search->query);    
    $storage->cacheResults($result, $search->queryHash);
}

echo $result;

// закрываем соединение
$storage->close();

