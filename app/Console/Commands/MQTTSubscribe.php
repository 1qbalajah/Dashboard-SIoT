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

        $mqtt->subscribe('iot/device/status', function ($topic, $message) {
            $this->info("TOPIC: $topic");
            $this->info("MESSAGE: $message");

            $data = json_decode($message, true);

            $device = Device::where('serial_number', $data['device_id'])->first();

            if (!$device) {
                $device = new Device();
                $device->serial_number = $data['device_id'];
            }

            $device->status = $data['status'];
            $device->topic = $topic;
            $device->updated_at = now();
            $device->save();

            Device::updateOrCreate(
                [
                    'serial_number' => $data['device_id']
                ],
                [
                    'status' => $data['status'],
                    'topic' => $topic,
                    'updated_at' => now(),
                ]
            );
        }, 0);

        $mqtt->loop(true);
    }
}
