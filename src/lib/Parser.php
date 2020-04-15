<?php 
namespace TestParser;

class Parser
{
    protected $pageUrl;

    public function __construct($pageUrl)
    {
        $this->pageUrl = $pageUrl;

        die($this->pageUrl);
    }
}


?>
