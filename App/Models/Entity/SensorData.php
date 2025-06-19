<?php
namespace App\Models\Entity;

class SensorData {
    public ?int $id;
    public ?int $sensorId;
    public ?string $timeRecorded;
    public ?float $value;
    const TABLE_NAME = 'sensorData';
}