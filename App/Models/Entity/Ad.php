<?php
namespace App\Models\Entity;
class Ad {
    public ?int $id;
    public ?string $address;
    public ?string $coordinates; #array of int separated by |
    public ?string $city; 
    public ?int $price;
    public ?int $surface;
    public ?string $gear; #array of int separated by |
    public ?int $applicationFee;
    public ?int $charges;
    public ?int $warranty;
    public ?string $availabilityDate;
    public ?int $numberOfBedrooms;
    public ?int $numberOfBathrooms;
    public ?string $duration;
    public ?string $description;
    public ?string $title;
    public ?int $floor;
    public ?bool $furnished;
    public ?bool $active;
    public ?bool $animals;
    public ?bool $verified;
    public ?int $apartmentType;
    public ?int $user_id;
    const TABLE_NAME="ad";
}