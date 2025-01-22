<?php
namespace App\Models\Entity;
class Candidate {
    public ?int $id;
    public ?int $user_id;
    public ?int $ad_id;
    public ?string $message;
    public ?string $dateAssociation;
    const TABLE_NAME='candidate';
}