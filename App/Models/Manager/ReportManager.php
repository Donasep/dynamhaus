<?php
namespace App\Models\Manager;

use App\Lib\Manager\AbstractManager;
use App\Models\Entity\Report;
class ReportManager extends AbstractManager{
    public function add(int $user_id, int $ad_id) {
        return $this->create(Report::class,["user_id"=>$user_id,"ad_id"=>$ad_id]);
    }
    public function findByUserAndAd(int $user_id, int $ad_id) {
        return $this->readOne(Report::class,["user_id"=>$user_id,"ad_id"=>$ad_id]);
    }
    public function countByAd(int $ad_id) {
        $query = "SELECT COUNT(*) FROM Report WHERE report.ad_id = ".$ad_id;
        $db=$this->connect();
        $stmt = $db->prepare($query);
        $stmt->execute();
		return $stmt->fetch();

    }
    public function delete(int $id) {
        return $this->remove(Report::class,$id);
    }
}