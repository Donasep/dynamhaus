<?php
namespace App\Models\Manager;

use App\Lib\Manager\AbstractManager;
use App\Models\Entity\Picture;

class PictureManager extends AbstractManager {
    public function find(int $id) {
        return $this->readOne(Picture::class,["id"=>$id]);
    }
    public function add(string $url, int $ad_id) {
        return $this->create(Picture::class,['url'=>$url,'ad_id'=>$ad_id]);
    }
    public function edit(int $id,string $url, int $ad_id) {
        return $this->update(Picture::class,["url"=>$url,'ad_id'=>$ad_id],$id);
    }
    public function delete(int $id) {
        return $this->remove(Picture::class,$id);
    }
    public function findByAd(int $ad_id) {
        $query="SELECT * FROM picture WHERE picture.ad_id = ".$ad_id;
        return $this->executeSimpleQuery($query,Picture::class);
    }
    public function findOneByAd(int $ad_id) {
        
    }
}