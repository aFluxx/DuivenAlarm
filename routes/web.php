<?php

use App\LosDataDuivenspel;
use App\LosDataKbdb;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/kbdb/table/{table}', 'KBDBTableController@show')->name('table.show');
