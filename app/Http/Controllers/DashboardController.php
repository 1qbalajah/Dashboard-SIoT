<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sensor;

class DashboardController extends Controller
{
    public function index()
    {
        $timeout = now()->subSeconds(15);

        // =========================
        // TOTAL DATA
        // =========================

        $totalDevice = Device::count();

        $totalSensor = Sensor::count();

        $devices = $this->deviceStatuses($timeout);

        // =========================
        // VIEW
        // =========================

        return view('dashboard', compact(
            'totalDevice',
            'totalSensor',
            'devices'
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

        $devices = $this->deviceStatuses($timeout);

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

    private function deviceStatuses($timeout)
    {
        return Device::select(['serial_number', 'updated_at'])
            ->latest('updated_at')
            ->get()
            ->map(function ($device) use ($timeout) {
                $isOnline = $device->updated_at &&
                    $device->updated_at->greaterThanOrEqualTo($timeout);

                return [
                    'serial_number' => $device->serial_number,
                    'status' => $isOnline ? 'online' : 'offline',
                ];
            });
    }
}
