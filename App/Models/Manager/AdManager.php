<?php
namespace App\Models\Manager;

use App\Lib\Manager\AbstractManager;
use App\Models\Entity\Ad;

class AdManager extends AbstractManager {
    public function find(int $id) {
        return $this->readOne(Ad::class,['id'=>$id]);
    }
    public function findOneBy(array $filters) {
        return $this->readOne(Ad::class, $filters);
    }    public function findAll() {
        return $this->readMany(Ad::class);
    }
    public function findBy(array $filters, array $order=[],int $limit= null, int $offset = null) {
        return $this->readMany(Ad::class,$filters,$order,$limit,$offset);
    }
    public function getRandom(int $limit=null,int $id=null,array $filter=null) {
        return $this->readManyRandom(Ad::class,$filter,$limit,$id);
    }
    public function findByUserTypeAndFilters(array $userTypes, array $filters, array $order=[],int $limit= null, int $offset = null) {
        $fromQuery = $this->readManyQuery(Ad::class,$filters, $order, $limit, $offset);
        $query="SELECT * FROM (".$fromQuery.") as a WHERE a.user_id IN (SELECT user.id FROM user WHERE user.role IN (";
        foreach($userTypes as $key=>$type) {
            $query.="'".$type."'";
            if ($key != array_key_last($userTypes)) $query .= ', ';
                        else $query .= '))';
        }
        return $this->executeSimpleQuery($query,Ad::class);
    }
    public function add(array $fields,int $userId) {
        return $this->create(Ad::class,[
            'address'=>$fields['address'],
            'coordinates'=>$fields['coordinates'],
            'city'=>$fields['city'],
            'price'=>$fields['price'],
            'surface'=>$fields['surface'],
            'gear'=>$fields['gear'],
            'applicationFee'=>$fields['applicationFee'],
            'charges'=>$fields['charges'],
            'warranty'=>$fields['warranty'],
            'availabilityDate'=>$fields['availabilityDate'],
            'numberOfBedrooms'=>$fields['numberOfBedrooms'],
            'numberOfBathrooms'=>$fields['numberOfBathrooms'],
            'description'=>$fields['description'],
            'title'=>$fields['title'],
            'floor'=>$fields['floor'],
            'furnished'=>$fields['furnished'],
            'active'=>$fields['active']??1,
            'animals'=>$fields['animals']??0,
            'verified'=>$fields['verified']??0,
            'apartmentType'=>$fields['apartmentType'],
            'user_id'=>$userId

            ]
        );
    }
    public function edit(Ad $ad) {
        return $this->update(Ad::class, [
            'address'=>$ad->address,
            'coordinates'=>$ad->coordinates,
            'city'=>$ad->city,
            'price'=>$ad->price,
            'surface'=>$ad->surface,
            'gear'=>$ad->gear,
            'applicationFee'=>$ad->applicationFee,
            'charges'=>$ad->charges,
            'warranty'=>$ad->warranty,
            'availabilityDate'=>$ad->availabilityDate,
            'numberOfBedrooms'=>$ad->numberOfBedrooms,
            'numberOfBathrooms'=>$ad->numberOfBathrooms,
            'description'=>$ad->description,
            'title'=>$ad->title,
            'floor'=>$ad->floor,
            'furnished'=>$ad->furnished,
            'active'=>$ad->active??1,
            'animals'=>$ad->animals,
            'verified'=>$ad->verified??1,
            'apartmentType'=>$ad->apartmentType,
            'user_id'=>$ad->user_id
            ],
        $ad->id
        );
    }
    public function delete(Ad $ad) {
        return $this->remove(Ad::class,$ad->id);
    }
    

}