<?php 
namespace TestParser\Contracts\Abstractions;

/**
 * Общий класс для объединения различных задач парсинга 
 */
abstract class ParserAbstract
{
    /**
     * Массив для хранения результатов парсинга
     *
     * @var array
     */
    public $items = [];

    /**
     * Url страницы реурса
     *
     * @var string
     */
    public $pageUrl = '';

    /**
     * Содержимое ресурса для парсинга
     *
     * @var string
     */
    public $rawSource = null;

    /**
     * Текст ошибки в случае, если не найдены результаты парсинга
     */
    const ERROR_NO_ITEMS = 'Результат парсинга данных пустой. Возможно изменился формат входных данных.';

    public function __construct($pageUrl)
    {
        $this->pageUrl = $pageUrl;

        $this->rawSource = $this->getHtml($pageUrl);
    }

    /**
     * Получаем сожеджимое страницы
     *
     * @param string $pageUrl адрес страницы
     * @return string сожеджимое страницы
     */
    public function getHtml($pageUrl = '')
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $this->pageUrl);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curlHandle);        

        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);

        if($httpCode != 200) {
            die('Ошибка получения данных. Ответ сервера: '.$httpCode);
        }

        return $response;
    }

    /**
     * Проверка на наличие результатов парсинга
     *
     * @return boolean
     */
    public function hasNoItems()
    {
        return (count($this->items) == 0) ;
    }

}
?>
