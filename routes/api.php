<?php

use App\LosDataDuivenspel;
use App\LosDataKbdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/data/kbdb', function () {
    return LosDataKbdb::get()->makeHidden(['id', 'created_at', 'updated_at']);
});

Route::middleware('auth:api')->get('/data/duivenspel', function () {
    return LosDataDuivenspel::get()->makeHidden(['id', 'created_at', 'updated_at']);
});

Route::middleware('auth:api')->get('/device/losplaatsen/subbed', 'FlightController@getSubbedFlights');
Route::middleware('auth:api')->get('/device/losplaatsen/unsubbed', 'FlightController@getUnsubbedFlights');

Route::middleware('auth:api')->post('/device/store', 'DeviceController@store')->name('device.store');

Route::middleware('auth:api')->get('/flight/{flight}/subscribe', 'SubscribeToFlightController')->name('flight.subscribe');
Route::middleware('auth:api')->get('/flight/{flight}/unsubscribe', 'UnsubscribeFromFlightController')->name('flight.unsubscribe');
