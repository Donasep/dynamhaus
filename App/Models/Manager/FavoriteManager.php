<?php
namespace App\Models\Manager;

use App\Lib\Manager\AbstractManager;
use App\Models\Entity\Favorite;
use App\Models\Entity\Ad;
class FavoriteManager extends AbstractManager{
    public function add(int $user_id, int $ad_id) {
        return $this->create(Favorite::class,["user_id"=>$user_id,"ad_id"=>$ad_id]);
    }
    public function getUserFavoriteAds(int $user_id,array $filters, $order=[],int $limit= null, int $offset = null) {
        $fromQuery = $this->readManyQuery(Ad::class,$filters, $order, $limit, $offset);
        $query="SELECT * FROM (".$fromQuery.") as a WHERE a.id IN (SELECT favorite.ad_id FROM favorite WHERE favorite.user_id = ".$user_id.")";
        return $this->executeSimpleQuery($query,Ad::class);
    }

    public function findByUserAndAd(int $user_id, int $ad_id) {
        return $this->readOne(Favorite::class,["user_id"=>$user_id,"ad_id"=>$ad_id]);
    }
    public function delete(int $id) {
        return $this->remove(Favorite::class,$id);
    }
}