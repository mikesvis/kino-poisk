<?php
require_once('../vendor/autoload.php');

use TestParser\Kinopoisk;

$parser = new Kinopoisk('https://www.kinopoisk.ru/top/');

$parser->process();

if($parser->hasNoItems())
    die(Kinopoisk::ERROR_NO_ITEMS);

foreach ($parser->getItems() as $item) {
    $item->store();
}

die(Kinopoisk::SUCCESS);

?>
