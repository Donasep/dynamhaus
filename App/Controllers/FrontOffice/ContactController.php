<?php
namespace App\Controllers\FrontOffice;

use App\Lib\Controller\AbstractController;
use App\Models\Entity\Contact;
use App\Models\Manager\ContactManager;
class ContactController extends AbstractController {
    public function postContact () {
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            return $this->renderView("contactUs.php", ['subject' => '']);

        }
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['subject'])&&isset($data['description'])&&isset($data['email'])&&isset($data['firstName'])&&isset($data['firstName'])) {
            $contactManager = new ContactManager();
            $contact = new Contact();
            $contact->subject=$data['subject'];
            $contact->description=$data['description'];
            $contact->email=$data['email'];
            $contact->firstName=$data['firstName'];
            $contact->lastName=$data['lastName'];
            $contactId=$contactManager->add($contact);
            if ($contactId) {
                echo json_encode(['state'=>'ok']);
            }

        }
    }
    public function deleteContact($slug_id) {
        $user = $this->checkUserRole(['ADMIN']);
        if (!$user) {
            return $this->setError404();
        }
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            exit;
        }
        $contactManager = new ContactManager();
        $contact = $contactManager->find($slug_id);
        if ($contact) {
            $contactManager->delete($contact->id);
            echo json_encode(['state'=>'ok']);
        }
        
        exit;
    }
    public function getContacts() {
        $user = $this->checkUserRole(['ADMIN']);
        if (!$user) {
            return $this->setError404();
        }
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            $contactManager = new ContactManager();
            $contacts = $contactManager->findAll();
            return $this->renderView('contactList.php',['contacts'=>$contacts]);
        }
    }
    public function readContact($slug_id) {
        $user = $this->checkUserRole(['ADMIN']);
        if (!$user) {
            return $this->setError404();
        }
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            $contactManager = new ContactManager();
            $contact = $contactManager->find($slug_id);
            if ($contact) {
                return $this->renderView('readContact.php',['contacts'=>$contact]);
            }
        }
    }
}