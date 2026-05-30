<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\MQTTService;

class LCDController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:32'
        ]);

        $mqtt = MQTTService::connect('laravel-lcd-' . uniqid());

        $mqtt->publish(
            'iot/lcd/message',
            $request->message,
            0,
            false
        );

        $mqtt->disconnect();

        return response()->json([
            'success' => true,
            'message' => 'Message sent to LCD'
        ]);
    }
}
