<?php 
namespace TestParser;

use TestParser\Interfaces\ParserInterface;

class Kinopoisk extends ParserClient implements ParserInterface
{

    public function process()
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $this->pageUrl);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curlHandle);        

        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);

        if($httpCode != 200) {
            die(self::ERROR_SOURCE.$httpCode);
        }

        $this->rawSource = $response;        

        $matches = [];

        $itemsPattern = "/<tr (?:bgcolor=\"\#eeeeee\"){0,1} id=\"top250_place_\d{1,3}\">(?:.|\n)*?<\/tr>/";

        preg_match_all($itemsPattern, $this->rawSource, $matches);

        if(count($matches[0]) == 0)
            die(Kinopoisk::ERROR_NO_ITEMS);

        ini_set('xdebug.var_display_max_data', -1);

        foreach ($matches[0] as $match) {

            $itemMatches = [];

            $itemPatterns = [
                'position' => "<a name=\"(\d{1,3})\">",
                'nameYearOriginalName' => "class=\"all\">(.*) \((\d{4})\)<\/a>(?:\&nbsp\;|.*<span class=\"text-grey\">(.*)<\/span>.*)<\/td>",
                "raiting" => "class=\"continue\">(.*)<\/a>",
                "votes" => "<span style=\"color: \#777\">\((.*)\)<\/span>"
            ];

            preg_match_all("/".implode("(?:.|\n)*?", $itemPatterns)."/", $match, $itemMatches, PREG_UNMATCHED_AS_NULL);

            var_dump($itemMatches);

            $item = new stdClass;            
            $item->position = $itemMatches[1][0] ?? null;
            $item->name = $itemMatches[2][0] ?? null;
            $item->year = $itemMatches[3][0] ?? null;
            $item->original = $itemMatches[4][0] ?? null;
            $item->raiting = $itemMatches[5][0] ?? null;
            $item->positionvotes = $itemMatches[6][0] ?? null;

            // $this->items[] = $item;
        }

        var_dump($this->items);


        die();

        return $this;
    }

    public function getItems()
    {
        var_dump($this->rawSource);
    }
}


?>
