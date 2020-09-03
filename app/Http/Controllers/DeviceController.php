<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function store(Request $request)
    {
        if (Device::where('token', $request->token)->first()) {
            return response()->json("Device is already saved in the database", 200);
        }

        $device = Device::create([
            'token' => $request->token,
        ]);

        return response()->json("A new device #{$device->id} with token: {$token} has been added", 200);
    }
}
