<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />

    <title>Топ 10 фильмов с kinopoisk</title>

</head>
<body>
    <div class="container">

        <div class="row my-4">
            <div class="col">
                <h1>Топ фильмов с kinopoisk</h1>
            </div>
        </div>
        
        <div class="row my-4">
            <div class="col-12">

                <form method="get" action="/search.php" id="searchForm">
                    <div class="form-row">
                        <div class="col-auto">
                            <input type="text" class="form-control datetimepicker-input" id="datetimepicker" data-toggle="datetimepicker" data-target="#datetimepicker" placeholder="Выберите дату" name="date" autocomplete="off" />
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary" id="search">Найти</button>
                        </div>                    
                    </div>
                </form>

            </div>            
        </div>

        <div class="row my-4">
            <div class="col-12">

                <table class="table table-bordered table-striped" id="results">
                    <thead class="thead-dark">
                        <tr>
                            <th>Место</th>
                            <th>Название / Оригинальное название</th>
                            <th>Год</th>
                            <th>Рейтинг</th>
                            <th>Кол-во голосов</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5"><div class="text-danger text-center">Укажите дату для поиска</div></td>                            
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>


    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
