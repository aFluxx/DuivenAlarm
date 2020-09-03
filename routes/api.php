<?php

use App\LosDataDuivenspel;
use App\LosDataKbdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/data/kbdb', function () {
    return LosDataKbdb::get()->makeHidden(['id', 'created_at', 'updated_at']);
});

Route::middleware('auth:api')->get('/data/duivenspel', function () {
    return LosDataDuivenspel::get()->makeHidden(['id', 'created_at', 'updated_at']);
});

Route::middleware('auth:api')->get('/device/store', 'DeviceController@store')->name('device.store');
