<?php
namespace App\Models\Entity;
class SensorParam {
    public ?int $sensorId;
    public ?float $samplingDelay;
    public ?bool $active;
    const TABLE_NAME = 'sensorParam';
}