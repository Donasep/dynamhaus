<?php
namespace App\Models\Entity;
class User {
    public ?int $id;
    public ?string $lastName;
    public ?string $firstName;
    public ?string $email;
    public ?string $password;
    const TABLE_NAME = 'user';
}