<?php
namespace App\Models\Manager;

use App\Lib\Manager\AbstractLocalManager;
use App\Models\Entity\User;
class UserManager extends AbstractLocalManager {
    public function add(User $utilisateur) {
        $this->create(User::class,[
        'firstName'=>$utilisateur->firstName,
        'lastName'=>$utilisateur->lastName,   
        'email'=>$utilisateur->email,
        'password'=>$utilisateur->password,
        ]);
    }
    public function findOneBy(array $fields) {
        return $this->readOne(User::class,$fields);
    } 

    public function findOneByEmail(string $email) {
        return $this->findOneBy(['email'=>$email]);
    }
    public function find(int $id) {
        return $this->findOneBy(["id"=>$id]);
    }
    public function save(User $user)
    {
        $fields = [
            'firstName' => $user->firstName,
            'lastName' => $user->lastName,
        ];

        if (property_exists($user, 'password') && !is_null($user->password)) {
            $fields['password'] = $user->password;
        }

        parent::update(User::class, $fields, $user->id);
    }
}