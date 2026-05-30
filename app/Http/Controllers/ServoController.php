<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MQTTService;

class ServoController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            // support BOTH formats:
            // 1) {"angle": 0-180}
            // 2) {"state": "on"|"off"}
            'angle' => 'nullable|integer|min:0|max:180',
            'state' => 'nullable|in:on,off',
        ]);

        $angle = $request->filled('angle')
            ? (int) $request->angle
            : ($request->state === 'off' ? 0 : 90);

        $mqtt = MQTTService::connect('laravel-servo-' . uniqid());

        $mqtt->publish(
            'iot/servo/control',
            (string) $angle,
            0,
            false
        );

        $mqtt->disconnect();

        return response()->json([
            'success' => true,
            'message' => 'Servo angle sent',
            'angle' => $request->angle,
        ]);
    }
}