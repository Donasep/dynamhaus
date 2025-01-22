<?php
namespace App\Models\Entity;
class Contact {
    public ?int $id;
    public ?string $email;
    public ?string $firstName;
    public ?string $lastName;
    public ?string $subject;
    public ?string $description;
    const TABLE_NAME='contact';
}