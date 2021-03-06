# Получение рейтинга фильмов с кинопоиска

## Cбор данных и запись в базу

Схема базы располагается в файле `schema.png`. Структура базы для Mysql в файле `test-parser-db.sql`.

Сбор и запись данных осуществляет скрипт `public/parser.php`. По исполнению кода всё расписано в самом файле. Классы, свойства и методы имееют документацию.

## Страница для отображения формы и резуьтатов поиска

Файл `public/index.php` служит для отображения результатов и формы поиска. Для верстки использовалься `Twitter Bootstrap 4`, в качестве js библиотеки `jQuery`. Для получения результатов поиска запускается ajax запрос на скрипт поиска результатов.

## Скрипт поиска сохраненных результатов

Поиск результатов по указанной дате осуществляет файл `public/search.php`. Присуствует кэширование ранее полученных результатов. После формирования запроса к базе, скрипт формирует хэш (sha1) на основе строки запроса. При наличии файла c именем хэш строки в папке `cache` результаты поиска выводятся из него. В случае, если данный файл не найден - запускаем запрос к базе и, в случае наличия результатов, создаем файл кэша для дальнейшего использования.

## Что улучшено

### Дамп для импорта

`test-parser-db.sql` переписан в соответствии с mysql 8

```mysql
SET NAMES utf8mb4; utf8 -> utf8mb4
id int(10) -> int (всё что связано с id)
`year` int(4) -> year,
ENGINE=InnoDB DEFAULT CHARSET=utf8 -> utfmb4;
float(4,3) -> float
```

### Запрос на позиции рейтинга

`/var/www/sites/test-parser/src/lib/Contracts/MySQL.php@createQuery`

Переписан запрос чтобы не убирать из `sql_mode` значение `ONLY_FULL_GROUP_BY`

### Настройки подключения в отдельный файл

`/var/www/sites/test-parser/src/lib/Contracts/MySQL.php@__construct`

Настройки конфигурации вынесены в отдельный файл `config.ini`, который не индексируется в репозитории. Создан пример конфигурационного файла `config.sample.ini`.

### По оптимизации

Добавлены индексы на столбцы `name`, `year` таблицы `movies`. Добавлен индекс на столбец `position` таблицы `raitings`. Данные изменения ускорили выборки.

По дальнейшей оптимизации: я бы изменил столбец с датой на тип `timestamp` и работал бы уже с таким видом данных в дате, но придётся изменить запрос на позиции.
