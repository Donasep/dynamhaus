<?php
namespace App\Models\Manager;
use App\Lib\Manager\AbstractManager;
use App\Models\Entity\Candidate;
use App\Models\Entity\User;
class CandidateManager extends AbstractManager {
    public function find(int $id) {
        return $this->readOne(Candidate::class,['id'=>$id]);
    }
    public function findOneBy(array $filters) {
        return $this->readOne(Candidate::class, $filters);
    }
    public function findAll() {
        return $this->readMany(Candidate::class);
    }
    public function findBy(array $filters, array $order=[],int $limit= null, int $offset = null) {
        return $this->readMany(Candidate::class,$filters,$order,$limit,$offset);
    }
    public function add(int $ad_id,int $user_id,string $message) {
        return $this->create(Candidate::class,['ad_id'=>$ad_id,'user_id'=>$user_id,'message'=>$message]);
    }
    public function delete(Candidate $candidate) {
        return $this->remove(Candidate::class,$candidate->id);
    }
    public function getCandidatesByAd(int $ad_id) {
        $query = "SELECT * FROM user WHERE user.id IN (SELECT user_id FROM candidate WHERE ad_id = '$ad_id')";
    return $this->executeSimpleQuery($query,User::class);
    }
}