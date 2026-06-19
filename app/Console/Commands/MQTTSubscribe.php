<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MQTTService;
use App\Models\Sensor;
use App\Models\Device;

class MQTTSubscribe extends Command
{
    protected $signature = 'mqtt:subscribe';

    protected $description = 'Subscribe MQTT Topics';

    public function handle()
    {
        $mqtt = MQTTService::connect('laravel-subscriber');

        $this->info('MQTT Listening...');
        $this->info('APP PATH: ' . base_path());
        $this->info('DB CONNECTION: ' . config('database.default'));
        $this->info('DB DATABASE: ' . config('database.connections.' . config('database.default') . '.database'));

        $mqtt->subscribe('iot/sensor/suhu', function ($topic, $message) {
            $this->info("TOPIC: $topic");
            $this->info("MESSAGE: $message");

            Sensor::create([
                'nama_sensor' => 'Suhu',
                'data' => $message,
                'status' => 1,
            ]);
        }, 0);

        $mqtt->subscribe('iot/sensor/kelembapan', function ($topic, $message) {
            $this->info("TOPIC: $topic");
            $this->info("MESSAGE: $message");

            Sensor::create([
                'nama_sensor' => 'Kelembapan',
                'data' => $message,
                'status' => 1,
            ]);
        }, 0);

        $mqtt->subscribe('iot/device/#', function ($topic, $message) {
            $this->info("TOPIC: $topic");
            $this->info("MESSAGE: $message");

            $data = json_decode($message, true);

            $serialNumber = is_array($data)
                ? ($data['device_id'] ?? $data['serial_number'] ?? $data['serial'] ?? $data['id'] ?? null)
                : trim($message);

            if (!$serialNumber) {
                $this->warn('Invalid device payload received. Expected JSON with device_id/serial_number or a plain serial number.');
                return;
            }

            $device = Device::updateOrCreate(
                [
                    'serial_number' => (string) $serialNumber
                ],
                [
                    'status' => 'online',
                    'topic' => $topic,
                    'updated_at' => now(),
                ]
            );

            $this->info("DEVICE SAVED: {$device->serial_number} ({$device->status})");
        }, 0);

        $mqtt->loop(true);
    }
}
