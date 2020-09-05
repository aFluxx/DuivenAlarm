<?php

namespace App\Http\Controllers;

use App\Device;
use App\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FlightController extends Controller
{
    public function getSubbedFlights(Request $request)
    {
        $device = Device::where('token', $request->query('token'))->first();

        if (count($device->subscribedFlights) > 0) {
            return response()->json($device->subscribedFlights, 200);
        } else {
            return response()->json([], 200);
        }
    }

    public function getUnsubbedFlights(Request $request)
    {
        $device = Device::where('token', $request->query('token'))->first();

        $subscribedFlightIds = $device->subscribedFlights->pluck('id');

        return response()->json(Flight::whereNotIn('id', $subscribedFlightIds)->get(), 200);
    }
}
