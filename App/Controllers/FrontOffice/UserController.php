<?php
namespace App\Controllers\FrontOffice;

use App\Lib\Controller\AbstractController;
use App\Lib\Mailer\Mailer;
use App\Models\Entity\User;
use App\Models\Manager\FavoriteManager;
use App\Models\Manager\AdManager;
use App\Models\Manager\PictureManager;
use App\Models\Manager\UserManager;
class UserController extends AbstractController
{
    public function getProfile()
    {
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            // Traitement pour le chargement de la page
            $user = $this->getCurrentUser();
            if ($user) {
                $state = $user->role == 'STUDENT';
                $method= $user->method == 'NATIVE';
                $ads = $this->getUserAds($user);
                $pictureManager = new PictureManager();
                foreach ($ads as $ad) {
                    $pictures = $pictureManager->findByAd($ad->id);
                    $ad = (array) $ad;
                    foreach ($pictures as $picture) {
                        $urls[] = explode("htdocs", $picture->url)[1];
                    }
                    $ad['urls'] = $urls ?? [];
                    $adsWithUrls[] = $ad;
                }

                return $this->renderView("profile.php", ['email' => $user->email, 'firstName' => $user->firstName, 'lastName' => $user->lastName, 'student' => $state, 'method'=>$method, 'ads' => $adsWithUrls ?? []]);
            } else {
                http_response_code(403);
                $this->setError404();

            }

        } else {
            $data = json_decode(file_get_contents('php://input'), true);
            $user = $this->getCurrentUser();
            if (!$user) {
                http_response_code(403);
                exit;
            }
            $user->firstName = $data['firstName'];
            $user->lastName = $data['lastName'];
            $userManager = new UserManager();
            $userManager->edit($user);
            echo json_encode(['state' => 'ok']);
            exit;
        }
    }
    private function getUserAds(User $user)
    {
        if ($user->role == "STUDENT") {
            $favoriteManager = new FavoriteManager();
            $favoriteAds = $favoriteManager->getUserFavoriteAds($user->id, [], [], 4);
            return $favoriteAds;
        } else {
            $adManager = new AdManager();
            $userAds = $adManager->findBy(['user_id' => [$user->id, '=']], [], 4);
            return $userAds;
        }
    }
    public function deleteCurrentUser()
    {
        $user = $this->getCurrentUser();
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            exit;
        }
        if (!$user) {
            exit;
        }
        $userManager = new UserManager();
        $_SESSION = array();
        session_regenerate_id(true);
        session_destroy();
        $userManager->delete($user);
    }

}