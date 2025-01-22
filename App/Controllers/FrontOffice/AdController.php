<?php
namespace App\Controllers\FrontOffice;

use App\Lib\Controller\AbstractController;
use App\Lib\ExternalApi\QueryAdresses;
use App\Lib\FileDealer\FileDealer;
use App\Models\Entity\Ad;
use App\Models\Manager\AdManager;
use App\Models\Manager\CandidateManager;
use App\Models\Manager\FavoriteManager;
use App\Models\Manager\PictureManager;
use App\Models\Manager\ReportManager;

class AdController extends AbstractController
{
    private function getadresses(string $adressQuery, int $limit = 5)
    {
        $queryAdresses = new QueryAdresses();
        $adresses = $queryAdresses->queryAdresses($adressQuery, $limit);
        return $adresses;
    }
    private function distance(array $coordinates1, array $coordinates2)
    {
        $distance = sqrt((floatval($coordinates1[0]) - floatval($coordinates2[0])) ** 2 + (floatval($coordinates1[1]) - floatval($coordinates2[1])) ** 2);
        return $distance;
    }

    private function filterByDistance(array $ads, array $centerCoordinates, int $radius)
    {
        foreach ($ads as $ad) {
            if (is_object($ad) && $ad instanceof Ad) {
                $coordinates = explode('|', $ad->coordinates);
                $distance = $this->distance($coordinates, $centerCoordinates);
                if ($distance <= ($radius * 1000)) {
                    $filteredAds[] = $ad;
                }
            }
        }
        return $filteredAds;
    }
    private function readManyWithFilters(array $filters, int $limit = null)
    {
        $adManager = new AdManager();
        return $adManager->findBy($filters, [], $limit);

    }

    private function getAroundLocationWithFilters(array $filters, array $adress, int $distance, array $userTypes = null)
    {
        if (!empty($userTypes) && count($userTypes) != 0) {
            $adManager = new AdManager();
            $ads = $adManager->findByUserTypeAndFilters($userTypes, $filters);
        } else {
            $ads = $this->readManyWithFilters($filters);
        }
        $filteredAds = $this->filterByDistance($ads, $adress['coordinates'], $distance);
        if ($filteredAds) {
            $filteredAds = array_slice($filteredAds, 0, 12);
        }
        return $filteredAds;
    }
    public function search()
    {
        $adManager = new AdManager();
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {

            $ads = $adManager->findBy([], [], 50);

            
            $pictureManager = new PictureManager();
        foreach ($ads as $key => $data) {
            $urls=[];
            $ads[$key] = (array) $data;
            $pictures = $pictureManager->findByAd($data->id);
            foreach ($pictures as $picture) {
                $urls[] = explode("htdocs", $picture->url)[1];
            }
            $ads[$key]['urls']=$urls;
        }
            return $this->renderView("annonces.php", ['ads' => $ads, "state" => "ok"]);
        }
        $search = json_decode(file_get_contents('php://input'), true);
        if ($search !== null) {
            $location = $search['address'];
            if ($location) {
                $adresses = $this->getadresses($location);
                if (!$adresses) {
                    return json_encode(['addressQueryState' => 'No result']);
                } else if (count($adresses) >= 2) {
                    echo json_encode(['addressQueryState' => 'Too many result', 'addressQueryResult' => $adresses]);
                    return true;
                } else {
                    $adress = $adresses[0];
                }
            } else {
                $city = $search['city'] ?? null;
                if ($city == null) {
                    echo json_encode(['adQuery' => 'No city']);
                    return false;
                }
            }

            if (!empty($search['moveInDate'])) {
                $filters['availabilityDate'] = [$search['moveInDate'], '<='];
            }
            if (!empty($search['appartmentType'])) {
                $filters['apartment_type'] = [$search['appartmentType']];
            }
            if (isset($search['minBudget']) && isset($search['maxBudget']) && !empty($search['minBudget']) && !empty($search['maxBudget'])) {
                $filters['price'] = [[$search['minBudget'], $search['maxBudget']], "BETWEEN"];
            }
            if (isset($search['minSurface']) && isset($search['maxSurface']) && $search['maxSurface'] >= $search['minSurface'] && $search['maxSurface'] != 0) {
                $filters['surface'] = [[$search['minSurface'], $search['maxSurface']], 'BETWEEN'];
            }
            if (!empty($search['numberOfRooms'])) {
                $filters['numberOfBedrooms'] = [$search['numberOfRooms'], "="];
            }
            if (!empty($search['furnished'])) {
                $filters['furnished'] = [$search['furnished'], "="];
            }
            if (!empty($search['animals'])) {
                $filters['animals'] = [$search['animal'], "="];
            }
            $filters['charges'] = [0, '<='];
            if (!empty($search['charges'])) {
                $filters['charges'] = [0, ">="];
            }
            if (!empty($search['proposedBy'])) {
                foreach ($search['proposedBy'] as $userType) {
                    if ($userType == 0) {
                        $userTypes[] = "INDIVIDUAL";
                    } else if ($userType == 1) {
                        $userTypes[] = "AGENCY";
                    } else if ($userType == 2) {
                        $userTypes[] = "RESIDENCE";
                    }
                }
            }


            if (!$location) {
                $filters['city'] = [$city, "="];
                $adManager = new AdManager();
                if (!empty($userTypes) && count($userTypes) != 0) {
                    $ads = $adManager->findByUserTypeAndFilters($userTypes, $filters);
                } else {
                    $ads = $adManager->findBy($filters, [], 50);
                    $pictureManager = new PictureManager();
        foreach ($ads as $key => $data) {
            $urls=[];
            $ads[$key] = (array) $data;
            $pictures = $pictureManager->findByAd($data->id);
            foreach ($pictures as $picture) {
                $urls[] = explode("htdocs", $picture->url)[1];
            }
            $ads[$key]['urls']=$urls;
        }
                }
                echo json_encode(['state' => "ok", 'ads' => $ads]);
                return true;
            } else {

                $ads = $this->getAroundLocationWithFilters($filters, $adress, 10);
                echo json_encode(['state' => 'ok', 'ads' => $ads]);
                return true;
            }
        } else {
            echo json_encode(['state' => 'No filters received']);
        }
    }


    public function home()
    {
        $adManager = new AdManager();
        $ads = $adManager->getRandom(4, null, ['city', ['Paris', "="]]);

        $pictureManager = new PictureManager();
        foreach ($ads as $key => $data) {
            $urls=[];
            $ads[$key] = (array) $data;
            $pictures = $pictureManager->findByAd($data->id);
            foreach ($pictures as $picture) {
                $urls[] = explode("htdocs", $picture->url)[1];
            }
            $ads[$key]['urls']=$urls;
        }
        return $this->renderView('homepage.php', ['state' => 'ok', 'ads' => $ads]);
    }

    public function singleAd($slug_id)
    {
        $adManager = new AdManager();
        if (!is_numeric($slug_id)) {
            $this->setError404();
        }
        $ad = $adManager->find($slug_id);
        if (!$ad) {
            $this->setError404();
        }
        $adWithUrlsAndFavorite = (array) $ad;
        $pictureManager = new PictureManager();
        $pictures = $pictureManager->findByAd($ad->id);
        foreach ($pictures as $picture) {
            $urls[] = explode("htdocs", $picture->url)[1];
        }
        $adWithUrlsAndFavorite['urls'] = $urls ?? [];

        $ads = $adManager->getRandom(4, $slug_id, ["city", [$ad->city, "="]]);
        
        foreach ($ads as $key => $data) {
            $urls=[];
            $ads[$key] = (array) $data;
            $pictures = $pictureManager->findByAd($data->id);
            foreach ($pictures as $picture) {
                $urls[] = explode("htdocs", $picture->url)[1];
            }
            $ads[$key]['urls']=$urls;
        }
        $user = $this->getCurrentUser();
        if ($user) {
            $favoriteManager = new FavoriteManager();
            $favorite = $favoriteManager->findByUserAndAd($user->id, $ad->id);
            $adWithUrlsAndFavorite['favorite'] = isset($favorite->id);

        } else {
            $adWithUrlsAndFavorite['favorite'] = false;
        }
        return $this->renderView('annonce.php', ['state' => 'ok', 'ad' => $adWithUrlsAndFavorite, 'otherAds' => $ads]);

    }

    public function addAd()
    {
        $user = $this->checkUserRole(["AGENCY", "RESIDENCE", "INDIVIDUAL"]);
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            // Traitement pour le chargement de la page
            return $this->renderView("create.php");
        }
        if (isset($_POST['address']) && isset($user)) {
            $adData = $_POST;
            $adresses = $this->getadresses($adData["address"]);
            if (empty($adresses)) {
                echo json_encode(["state" => 'No result for adress']);
                return null;
            } else if (count($adresses) >= 2) {
                $lightAdresses=[];
                foreach($adresses as $adress) {
                    $lightAdresses[]=$adress['label'];
                }
                echo json_encode(['state' => "Too much result", "adresses" => $lightAdresses]);
                return null;
            } else {
                $adress = $adresses[0];
                $adData['coordinates'] = $adress['coordinates'][0] . "|" . $adress['coordinates'][1];
                $adData['address'] = $adress['label'];
                $adData['city'] = $adress['city'];
                $adManager = new AdManager();
                $ad_id = $adManager->add($adData, $user->id);
                if ($ad_id) {

                    if (isset($_FILES["pictures"])) {
                        $pictureManager = new PictureManager();
                        $fileDealer = new FileDealer();
                        $urls = $fileDealer->uploadMedia("ad_pictures", $ad_id);
                        foreach ($urls as $url) {
                            $pictureManager->add($url, $ad_id);
                        }
                    }
                    echo json_encode(['state' => 'Successful']);
                    return null;
                } else {
                    echo json_encode(['state' => 'Something went wrong']);
                    return null;
                }
            }
        } else {
            echo json_encode(['state' => 'Something went wrong']);
            return null;
        }
    }

    public function ModifyAd($slug_id)
    {
        $adManager = new AdManager();
        $ad = $adManager->find($slug_id);
        if ($ad) {
            $user = $this->checkUserRole(["AGENCY", "RESIDENCE", "INDIVIDUAL"]);
            if ($user->id !== $ad->user_id) {
                $this->setError404();
            }
            if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
                $pictureManager = new PictureManager();
                $pictures = $pictureManager->findByAd($ad->id);
                foreach ($pictures as $picture) {
                    $urls[] = explode("htdocs", $picture->url)[1];
                }
                $adWithUrls = (array) $ad;
                $adWithUrls["urls"] = $urls ?? [];
                return $this->renderView("modify.php", ['ad' => $adWithUrls]);
            }
            if (isset($user)) {
                $adData = $_POST;
                $oldAdData = (array) $ad;
                $newAdData = array_merge($oldAdData, $adData);
                foreach ($newAdData as $key => $value) {
                    $ad->$key = $value;
                }
                $adManager->edit($ad);
                if (isset($_FILES["pictures"])) {
                    $pictureManager = new PictureManager();
                    $pictures = $pictureManager->findByAd($ad->id);
                    foreach ($pictures as $picture) {
                        $pictureManager->delete($picture->id);
                    }
                    $fileDealer = new FileDealer();
                    $urls = $fileDealer->uploadMedia("ad_pictures", $ad->id);
                    foreach ($urls as $url) {
                        $pictureManager->add($url, $ad->id);
                    }
                }
                return null;
            }
        } else {
            $this->setError404();
        }
    }
    public function updateFavorite($slug_id) {
        $user = $this->checkSessionState();
        if ($user) {
            $adManager = new AdManager();
            $ad = $adManager->find($slug_id);
            if ($ad) {
                $favoriteManager = new FavoriteManager();
                $favorite=$favoriteManager->findByUserAndAd($user->id, $ad->id);
                if ($favorite) {
                    $favoriteManager->delete($favorite->id);
                echo json_encode(['state'=>'ok','favoriteState'=>0]);
                exit;
                } else {
                    $favoriteManager->add($user->id, $ad->id);
                    echo json_encode(['state'=>'ok','favoriteState'=>1]);
                    exit;
                }
            }
            http_response_code(404);
            echo json_encode(["state" => "Error 404 NotFound"]);
        }
        http_response_code(401);
        echo json_encode(["state" => "Error 401 Unauthorized"]);
        return null;
    }

    public function deleteAd($slug_id)
    {

        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            return null;
        }
        $adManager = new AdManager();
        $ad = $adManager->find($slug_id);
        if ($ad) {
            $user = $this->checkUserRole(["AGENCY", "RESIDENCE", "INDIVIDUAL"]);
            if (!$user || (!$user->id == $ad->user_id && $user->role != "ADMIN")) {
                http_response_code(403);
                echo json_encode(["state" => "Error 403 Forbidden"]);
                exit;
            }
            $adManager->delete($ad);
            return json_encode(['state' => 'Ok']);
        }
    }
    private function getAdCandidates (int $ad_id) {
        $candidateManager = new CandidateManager();
        $users=$candidateManager->getCandidatesByAd($ad_id);
        $usersWithMessage=[];
        foreach($users as $user) {
            $user = (array) $user;
            $candidate=$candidateManager->findOneBy(['user_id'=>[$user['id'],'='],'ad_id'=>[$ad_id,"="]]);
            $user['message']=$candidate->message;
            $usersWithMessage[]=$user;
        }
        return $usersWithMessage;
    }
    public function candidateToAd() {
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            exit;
        }
        $adManager = new AdManager();
        $data=json_decode(file_get_contents('php://input'), true);
        $ad = $adManager->find($data['ad_id']);
        if ($ad) {
            $user = $this->checkUserRole(["STUDENT"]);
            if (!$user) {
                http_response_code(401);
                echo json_encode(["state" => "Error 401 Unauthorized"]);
                exit;
            }
            $candidateManager = new CandidateManager();
            $candidateManager->add($ad->id,$user->id,$data['message']);
            echo json_encode(['state' => 'Ok']);
            exit;
        } else {
            http_response_code(404);
                echo json_encode(["state" => "Error 404 NotFound"]);
        }
    }
    public function updateReport($slug_id) {
        $user = $this->checkSessionState();
        if ($user) {
            $adManager = new AdManager();
            $ad = $adManager->find($slug_id);
            if ($ad) {
                $reportManager = new ReportManager();
                $report=$reportManager->findByUserAndAd($user->id, $ad->id);
                if ($report) {
                    $reportManager->delete($report->id);
                echo json_encode(['state'=>'ok','reportState'=>0]);
                exit;
                } else {
                    $reportManager->add($user->id, $ad->id);
                    echo json_encode(['state'=>'ok','reportState'=>1]);
                    exit;
                }
            }
            http_response_code(404);
            echo json_encode(["state" => "Error 404 NotFound"]);
        }
        http_response_code(401);
        echo json_encode(["state" => "Error 401 Unauthorized"]);
        return null;
    }



}
