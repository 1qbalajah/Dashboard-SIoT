<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sensor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // TOTAL DATA
        // =========================

        $totalDevice = Device::count();

        $totalSensor = Sensor::count();

        // =========================
        // AKTIVITAS TERBARU
        // =========================

        $recentDevices = Device::select(
            'id',
            'serial_number as title',
            'topic as description',
            'created_at',
            DB::raw("'device' as type")
        )
            ->latest()
            ->limit(5)
            ->get();

        $recentSensors = Sensor::select(
            'id',
            'nama_sensor as title',
            'data as description',
            'created_at',
            DB::raw("'sensor' as type")
        )
            ->latest()
            ->limit(5)
            ->get();

        $recentActivities = $recentDevices
            ->concat($recentSensors)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        // =========================
        // VIEW
        // =========================

        return view('dashboard', compact(
            'totalDevice',
            'totalSensor',
            'recentActivities'
        ));
    }

    // =====================================
    // REALTIME FETCH API
    // =====================================

    public function realtimeData()
    {
        // Timeout untuk menentukan "last seen" device (status offline kalau tidak ada topic lagi dalam window ini)
        $timeout = now()->subSeconds(15);

        $temperature = Sensor::select(['id', 'data', 'updated_at'])
            ->where('nama_sensor', 'Suhu')
            ->latest()
            ->first();

        $humidity = Sensor::select(['id', 'data', 'updated_at'])
            ->where('nama_sensor', 'Kelembapan')
            ->latest()
            ->first();

        $devices = Device::select(['serial_number', 'status', 'topic', 'updated_at'])
            ->latest('updated_at')
            ->get()
            ->map(function ($device) use ($timeout) {
                $isOnline = $device->updated_at &&
                    $device->updated_at->greaterThanOrEqualTo($timeout);

                return [
                    'serial_number' => $device->serial_number,
                    'status' => $isOnline ? 'online' : 'offline',
                    'topic' => $device->topic,
                    'updated_at' => optional($device->updated_at)->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            // Sensor juga pakai timeout, biar OFFLINE saat tidak ada update
            'temperature' => $temperature && $temperature->updated_at && $temperature->updated_at->greaterThanOrEqualTo($timeout)
                ? ['data' => $temperature->data]
                : null,

            'humidity' => $humidity && $humidity->updated_at && $humidity->updated_at->greaterThanOrEqualTo($timeout)
                ? ['data' => $humidity->data]
                : null,

            'devices' => $devices->values(),
        ])->header('Cache-Control', 'no-store, max-age=0');
    }
}
