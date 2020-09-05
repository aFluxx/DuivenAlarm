<?php

use \App\Http\Controllers\KBDBTableController;

?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KBDB Table {{ $table->id }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

</head>

<body>
    <h2>{!! $table->lossingsinformatie !!}</h2>
    <a href="{{ KBDBTableController::findPrevious($table->id) }}">Vorige iteratie tabel</a>
    <a href="{{ KBDBTableController::findNext($table->id) }}">Volgende iteratie tabel</a>
    <br />
    <table>{!! $table->html !!}</table>
</body>

</html>
