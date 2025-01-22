<?php
namespace App\Models\Entity;
class User {
    public ?int $id;
    public ?string $email;
    public ?string $password;
    public ?string $lastName;
    public ?string $firstName;
    public ?string $role;
    public ?bool $verified;
    public ?string $avatarUrl;
    public ?string $method;
    const TABLE_NAME = 'user';
}


