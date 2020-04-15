<?php 
namespace TestParser;

interface ParserInterface
{
    public function process();

    public function getItems();

    public function hasNoItems();

    public function fail();

    public function success();
}
?>
