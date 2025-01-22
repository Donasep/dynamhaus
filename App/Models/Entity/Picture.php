<?php
namespace App\Models\Entity;

class Picture {
    public ?int $id;
    public ?string $url;
    public ?int $ad_id;

    const TABLE_NAME="picture";
}