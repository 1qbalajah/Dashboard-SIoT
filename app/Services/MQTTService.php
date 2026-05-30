<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MQTTService
{
    public static function connect(?string $clientId = null)
    {
        $server = env('MQTT_HOST');
        $port = (int) env('MQTT_PORT');

        $clientId = $clientId ?? 'laravel-publisher-' . uniqid();

        $mqtt = new MqttClient($server, $port, $clientId);

        $settings = (new ConnectionSettings)
            ->setUsername(env('MQTT_USERNAME'))
            ->setPassword(env('MQTT_PASSWORD'));

        $mqtt->connect($settings, true);

        return $mqtt;
    }
}