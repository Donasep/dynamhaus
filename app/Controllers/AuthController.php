<?php
namespace App\Controllers;

use App\Lib\Authentification\Authentification;
use App\Lib\Controller\AbstractController;
use App\Models\Entity\User;
use App\Models\Manager\UserManager;
class AuthController extends AbstractController {
    public function signup()
    {
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            return $this->renderView("inscription.php");
        }

        $json_user = json_decode(file_get_contents('php://input'), true);

        $userManager = new UserManager();

        if ($json_user['email'] && $json_user['firstName'] && $json_user['lastName'] && $json_user['password']) {
            $user = $userManager->findOneByEmail($json_user['email'] ?? "");

            if (!$user) {
                $user = new User();
                $user->email = $json_user['email'];
                $user->firstName = $json_user['firstName'];
                $user->lastName = $json_user['lastName'];
                $user->password = hash('sha512', $json_user['password']);

                $userManager->add($user);
                /*
                $mailer = new Mailer();
                $auth = new Authentification();
                $verificationToken = $auth->genJwtForEmailValidation($userId);

                $mailer->sendEmailVerificationMail($user, $verificationToken);
                */
                echo json_encode(["state" => "ok"]);
            } else {
                echo json_encode(["state" => "This email is already being used"]);
                return null;
            }
        } else {
            echo json_encode(["state" => "Invalid Json"]);
            return null;
        }
    }
    public function signin()
    {
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            return $this->renderView("login.php");
        }
        $auth = new Authentification(); // init de auth
        $userManager = new UserManager();
        $json_user = json_decode(file_get_contents('php://input'), true);
        if ($json_user['email'] && $json_user['password']) {
            $user = $userManager->findOneByEmail($json_user['email'] ?? "");
                if ($this->verifyPassword($user, $json_user['password'])) {
                        session_regenerate_id(true);
                        $_SESSION['token'] = $auth->Gen_jwt($user->id);


                        echo json_encode(["state" => "Connected"]);
                        return null;

                } else {
                    echo json_encode(["state" => "Invalid credentials"]);
                    return null;
                }
            
        } else {
            echo json_encode(["state" => "Invalid Json"]);
            return null;
        }
    }
    public function signout()
    {

        $_SESSION = array();
        session_regenerate_id(true);
        session_destroy();
        return $this->redirectToRoute("/");
    }
}