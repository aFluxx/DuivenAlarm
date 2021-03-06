<?php

namespace App\Http\Controllers;

use App\Device;
use App\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscribeToFlightController extends Controller
{
    public function __invoke(Flight $flight, Request $request)
    {
        $device = Device::where('token', $request->query('token'))->first();

        Log::info('subscribing');

        if (!$device->subscribedFlights->contains($flight->id)) {
            $device->subscribedFlights()->attach($flight);
        }

        return response()->json($flight, 200);
    }
}
