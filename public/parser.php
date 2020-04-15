<?php
require_once('../vendor/autoload.php');

use TestParser\Parser;

$parser = new Parser('https://www.kinopoisk.ru/top/');

// $parser = (new Parser('https://www.kinopoisk.ru/top/'))->process();

// if($parser->hasNoItems())
//     die('Oops... no items parsed!');

// foreach ($parser->items as $item) {
//     $item->store();
// }

// echo 1;

?>
