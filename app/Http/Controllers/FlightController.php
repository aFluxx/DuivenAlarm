<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $device = Device::where('token', $request->query('token'))->first();

        if (count($device->subscribedFlights) > 0) {
            return response()->json($device->subscribedFlights, 200);
        } else {
            return response()->json([
                'type' => 'no-subs',
                'message' => 'User has no subscribed flights yet',
            ], 200);
        }
    }
}
