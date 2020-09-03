<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/data-kbdb', function () {
    return LosDataKbdb::get()->makeHidden(['id', 'created_at', 'updated_at']);
});

Route::middleware('auth:api')->get('/data-duivenspel', function () {
    return LosDataDuivenspel::get()->makeHidden(['id', 'created_at', 'updated_at']);
});
