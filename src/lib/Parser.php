<?php 
namespace TestParser;

class Parser implements ParserInterface
{
    protected $items;
    protected $pageUrl;

    public function __construct($pageUrl)
    {
        $this->pageUrl = $pageUrl;

        die($this->pageUrl);
    }

    public function process()
    {
        
    }

    public function getItems()
    {
        
    }

    public function hasNoItems()
    {
        
    }

    public function fail()
    {
        
    }

    public function success()
    {
        
    }
}


?>
