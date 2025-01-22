<?php
namespace App\Lib\ExternalApi;

use Transliterator;
class QueryAdresses {
    public function queryAdresses (string $adressQuery, int $limit = 5) {
        $explodedAdressQuery = explode(" ",rtrim(ltrim($adressQuery," ")," "));
        $implosedAdressQuery = implode("+",$explodedAdressQuery);
        $curl = curl_init("https://api-adresse.data.gouv.fr/search/?q=$implosedAdressQuery&limit=$limit&type=housenumber");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response=curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);
        if (isset($error_msg)) {
            throw new \ErrorException($error_msg);
        }
        $geojson = json_decode($response,true);
        if ($geojson) {
            foreach ($geojson["features"] as $adressjson) {
                if ($adressjson["properties"]["score"]>=0.8) {
                    $coordinates = [$adressjson["properties"]["x"],$adressjson["properties"]["y"]];
                    $label=$adressjson["properties"]["label"];
                    $city=$adressjson["properties"]["city"];
                    $adresses[]=["coordinates" => $coordinates,"label" => $label,"city"=>$city];
                } else {
                    break;
                }
            }
        }
        return $adresses??null;
    }
}