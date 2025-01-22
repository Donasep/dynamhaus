<?php
namespace App\Models\Entity;
class Alert {
    public ?int $id;
    public ?string $address;
    public ?int $minPrice;
    public ?int $maxPrice;
    public ?int $minSurface;
    public ?int $maxSurface;
    public ?int $radius;
    public ?string $proposedBy;
    public ?int $apartmentType;
    public ?string $coordinates;
    public ?int $user_id;
    const TABLE_NAME='alert';
}