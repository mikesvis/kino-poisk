<?php
require_once('../vendor/autoload.php');

use TestParser\Parser;

$parser = new Parser('https://www.kinopoisk.ru/top/');
$parser->process();

if($parser->hasNoItems())
    $parser->fail();

foreach ($parser->getItems() as $item) {
    $item->store();
}

$parser->success();

?>
