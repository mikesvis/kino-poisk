<?php 
namespace TestParser;

use TestParser\Contracts\Interfaces\ParserItemInterface;

/**
 * Класс результатов парсинга фильма с кинопоиска
 */
class Movie implements ParserItemInterface
{

    /**
     * Позиция в рейтинге
     *
     * @var string
     */
    public $position;

    /**
     * Наименование фильма
     *
     * @var string
     */
    public $name;

    /**
     * Год выпуска
     *
     * @var string
     */
    public $year;

    /**
     * Оригинальное наименование фильма
     *
     * @var string
     */
    public $original;

    /**
     * Рейтинг фильма
     *
     * @var string
     */
    public $raiting;

    /**
     * Кол-во проголосовавших
     *
     * @var string
     */
    public $votes;

    /**
     * мэппинг соответсвия парсинга и свойства объекта
     */
    const MATCHES_MAPPER = [
        'position' => 1,
        'name' => 2,
        'year' => 3,
        'original' => 4,
        'raiting' => 5,
        'votes' => 6,
    ];

    /**
     * Заполнение свойств объекта полученными данными
     *
     * @param array $matches
     * @return void
     */
    public function fillFromMatches($matches = [])
    {
        foreach ($this as $key => $value) {
            if(isset($matches[self::MATCHES_MAPPER[$key]])){
                $this->{$key} = null;

                if(count($matches[self::MATCHES_MAPPER[$key]]) == 1) {
                    $this->{$key} = $matches[self::MATCHES_MAPPER[$key]][0];
                    if($key == 'votes')
                        $this->{$key} = preg_replace("/\D/", "", $matches[self::MATCHES_MAPPER[$key]][0]);
                } else {
                    $this->{$key} = $matches[self::MATCHES_MAPPER[$key]];
                }

            }
        }

    }

    /**
     * Проверка объекта на пустые данные
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this);
    }

}


?>
