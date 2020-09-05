<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{
    public function store(Request $request)
    {
        Log::info('got in');
        if (Device::where('token', $request->token)->first() != null) {
            return response()->json("Device is already saved in the database", 200);
        } else {
            $device = Device::create([
                'token' => $request->token,
            ]);
            $device->save();

            return response()->json("A new device #{$device->id} with token: {$request->token} has been added", 200);
        }
    }
}
