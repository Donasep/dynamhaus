<?php
namespace App\Models\Entity;
class Article {
    public ?int $id;
    public ?int $position;
    public ?string $title;
    public ?string $description;
    public ?string $type;
    const TABLE_NAME='article';
}