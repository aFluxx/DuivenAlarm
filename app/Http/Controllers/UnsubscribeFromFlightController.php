<?php

namespace App\Http\Controllers;

use App\Device;
use App\Flight;
use Illuminate\Http\Request;

class UnsubscribeFromFlightController extends Controller
{
    public function __invoke(Flight $flight, Request $request)
    {
        $device = Device::where('token', $request->query('token'))->first();

        if ($device->subscribedFlights->contains($flight->id)) {
            $device->subscribedFlights()->detach($flight);
        }

        return response()->json($flight, 200);
    }
}
