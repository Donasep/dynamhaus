<?php
namespace App\Models\Manager;

use App\Lib\Manager\AbstractManager;
use App\Models\Entity\User;
class UserManager extends AbstractManager {
    public function find(int $id) {
        return $this->readOne(User::class,['id'=>$id]);
    }
    public function findOneBy(array $filters) {
        return $this->readOne(User::class, $filters);
    }
    public function findAll() {
        return $this->readMany(User::class);
    }
    public function findBy(array $filters, array $order=[],int $limit= null, int $offset = null) {
        return $this->readMany(User::class,$filters,$order,$limit,$offset);
    }
    public function add(User $user) {
        return $this->create(User::class,[
            'email'=>$user->email,
            'password'=>$user->password,
            'lastName'=>$user->lastName,
            'firstName'=>$user->firstName,
            'method'=>$user->method??'NATIVE',
            ]
        );

    }
    public function edit(User $user) {
        return $this->update(User::class, [
            'email'=>$user->email,
            'password'=>$user->password,
            'lastName'=>$user->lastName,
            'firstName'=>$user->firstName,
            'role'=>$user->role,
            'verified'=>$user->verified,
            'avatarUrl'=>$user->avatarUrl
            ],
        $user->id
        );
    }
    public function delete(User $user) {
        return $this->remove(User::class,$user->id);
    }
    
    public function findOneByEmail(string $email) {
        return $this->findOneBy(['email'=>$email]);
    }
}
