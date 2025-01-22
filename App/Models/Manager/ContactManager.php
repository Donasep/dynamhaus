<?php
namespace App\Models\Manager;
use App\Lib\Manager\AbstractManager;
use App\Models\Entity\Contact;
class ContactManager extends AbstractManager {
    public function find(int $id) {
        return $this->readOne(Contact::class,['id'=>$id]);
    }
    public function findOneBy(array $filters) {
        return $this->readOne(Contact::class, $filters);
    }
    public function findAll() {
        return $this->readMany(Contact::class);
    }
    public function findBy(array $filters, array $order=[],int $limit= null, int $offset = null) {
        return $this->readMany(Contact::class,$filters,$order,$limit,$offset);
    }
    public function add(Contact $contact) {
        return $this->create(Contact::class,(array) $contact);
    }
    public function delete(Contact $Contact) {
        return $this->remove(Contact::class,$Contact->id);
    }
}