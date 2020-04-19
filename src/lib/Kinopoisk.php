<?php 
namespace TestParser;

use TestParser\Contracts\ParserItem;
use TestParser\Contracts\Interfaces\ParserInterface;
use TestParser\Contracts\Abstractions\ParserAbstract;

/**
 * Класс для парсинга данных по позициям в ретинге фильмов кинопоиска
 */
class Kinopoisk extends ParserAbstract implements ParserInterface
{    
    /**
     * Получаем результаты парсинга и собираем их в массив
     *
     * @return ParserInterface
     */
    public function findItems()
    {
        $matches = [];

        // находим все позиции с фильмами
        $itemsPattern = "/<tr (?:bgcolor=\"\#eeeeee\"){0,1} id=\"top250_place_\d{1,3}\">(?:.|\n)*?<\/tr>/";

        preg_match_all($itemsPattern, $this->rawSource, $matches);

        // позиции не найдены - выходим
        if(count($matches[0]) == 0)
            die(self::ERROR_NO_ITEMS);

        // обрабатываем каждую позицию по отдельности
        foreach ($matches[0] as $match) {
            $itemMatches = [];

            // паттерны для необходимых данных
            $itemPatterns = [
                'position' => "<a name=\"(\d{1,3})\">",
                'nameYearOriginalName' => "class=\"all\">(.*) \((\d{4})\)<\/a>(?:\&nbsp\;|.*<span class=\"text-grey\">(.*)<\/span>.*)<\/td>",
                "raiting" => "class=\"continue\">(.*)<\/a>",
                "votes" => "<span style=\"color: \#777\">\((.*)\)<\/span>"
            ];

            preg_match_all("/".implode("(?:.|\n)*?", $itemPatterns)."/", $match, $itemMatches, PREG_UNMATCHED_AS_NULL);

            // мы парсим фильмы и их ретинг - соответственно создаем нужный объект
            $movieItem = new Movie();

            // передаем осозданный объект для дальнейшего заполнения свойств через инъекцию
            $parserItem = new ParserItem($movieItem);

            // заполняем данные на основе парсинга
            $parserItem->fillFromMatches($itemMatches);
            
            // получается что объект пустой, он нам не нужен
            if($parserItem->isEmpty())
                continue;

            // добавляем в массив результатов парсинга
            $this->items[] = $parserItem->item;
        }
        
        // массив с результатами парсинга пустой - выходим с сообщением
        if($this->hasNoItems())
            die(self::ERROR_NO_ITEMS);

        return $this;
    }

}


?>
