<?php
namespace App\Models\Entity;
class Message {
    public ?int $id;
    public ?string $message;
    public ?bool $readState;
    public ?\DateTime $uploadTime;
    public ?int $user_id;
    public ?int $conversation_id;
    const TABLE_NAME='message';
}