<?php 
namespace TestParser\Contracts;

use TestParser\Contracts\Interfaces\ParserInterface;

/**
 * Класс парсера
 */
class Parser
{

    /**
     * Данные парсинга
     *
     * @var mixed
     */
    public $data;
    
    public function __construct(ParserInterface $data)
    {
        $this->data = $data;
    }

}

?>
