<?php
namespace App\Models\Manager;

use App\Lib\Manager\AbstractManager;
use App\Models\Entity\Message;
class MessageManager extends AbstractManager {
    public function getConversationMessages($conversationId) {
        return $this->readManyQuery(Message::class,["conversation_id"=>[$conversationId,"="]],["uploadTime"=>"DESC"]);
    }
}