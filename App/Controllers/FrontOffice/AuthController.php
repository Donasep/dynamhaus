<?php
namespace App\Controllers\FrontOffice;

use App\Lib\Authentification\Authentification;
use App\Lib\Controller\AbstractController;
use App\Lib\ExternalApi\GoogleOAuth\GoogleOAuth;
use App\Lib\Mailer\Mailer;

use App\Models\Entity\User;
use app\Models\Manager\UserManager;

class AuthController extends AbstractController
{

    public function signup()

{
    if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
        return $this->renderView("signup.php");
    }

    $json_user = json_decode(file_get_contents('php://input'), true); 

    $recaptchaResponse = $json_user['recaptcha_response'] ?? null;
    // var_dump($recaptchaResponse);
    $recaptchaSecret = $_ENV['RECAPTCHA_SECRET_KEY'];

    if (empty($recaptchaResponse)) {
        echo json_encode(["state" => "reCAPTCHA missing or invalid"]);
        return null;
    }

    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaData = [
        'secret' => $recaptchaSecret,
        'response' => $recaptchaResponse,
    ];

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptchaData),
        ],
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($recaptchaUrl, false, $context);

    $responseKeys = json_decode($response, true);

    if (intval($responseKeys['success']) !== 1) {
        echo json_encode(["state" => "reCAPTCHA verification failed"]);
        return null;
    }

    $userManager = new UserManager();

    if ($json_user['email'] && $json_user['firstName'] && $json_user['lastName'] && $json_user['password']) {
        $user = $userManager->findOneByEmail($json_user['email'] ?? "");
        
        if (!$user) {
            $user = new User();
            $user->email = $json_user['email'];
            $user->firstName = $json_user['firstName'];
            $user->lastName = $json_user['lastName'];
            $user->password = hash('sha512', $json_user['password']);

            $userId = $userManager->add($user);

            $mailer = new Mailer();
            $auth = new Authentification();
            $verificationToken = $auth->genJwtForEmailValidation($userId);

            $mailer->sendEmailVerificationMail($user, $verificationToken);

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
            return $this->renderView("signin.php");
        }
        $auth = new Authentification(); // init de auth
        $userManager = new UserManager();
        $json_user = json_decode(file_get_contents('php://input'), true);
        if ($json_user['email'] && $json_user['password']) {
            $user = $userManager->findOneByEmail($json_user['email'] ?? "");
            if ($user&&$user->method=="NATIVE") {
                if ($this->verifyPassword($user, $json_user['password'])) {
                    if ($user->verified) {
                        session_regenerate_id(true);
                        $_SESSION['token'] = $auth->Gen_jwt($user->id);

                        if (!empty($user->avatarUrl)) {
                        if (str_contains($user->avatarUrl,'http')) {
                            $_SESSION['url']=$user->avatarUrl;
                        } else {
                            $_SESSION['url']=explode("htdocs", $user->avatarUrl)[1];
                        }
                    }

                        echo json_encode(["state" => "Connected"]);
                        return null;
                    } else {
                        $mailer = new Mailer();
                        $verificationToken = $auth->genJwtForEmailValidation($user->id);
                        $mailer->sendEmailVerificationMail($user, $verificationToken);
                        echo json_encode(["state" => "Email is not verified"]);
                        return null;
                    }

                } else {
                    echo json_encode(["state" => "Invalid credentials"]);
                    return null;
                }
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
        return $this->redirectToRoute("");
        #$_SESSION['dcpl']['exp'] = Null; // use session_destroy() (look at PHP manual)
    }
    public function verifyAccount(string $slug_token)
    {
        $auth = new Authentification();
        $userId = $auth->Validate_jwt($slug_token)['Jwt']['dcpl']['userId'];
        if (!$userId) {
            return $this->renderView("expiredLink.php", ['state' => 'Token is expired']);
        } else {
            $userManager = new UserManager;
            $user = $userManager->find($userId);
            if ($user) {
                $user->verified = true;
                $userManager->edit($user);
                return $this->renderView("", ['state' => 'email verified']);
            }
            return null;
        }
    }

    public function sendResetPasswordMail()
    {   
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            return $this->renderView('sendResetPasswordMail.php');
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $userManager = new UserManager();
        $user = $userManager->findOneByEmail($data['email']);

        if ($user&&$user->method=="NATIVE") {

            $mailer = new Mailer();
            $auth = new Authentification();
            $resetToken = $auth->genJwtForEmailValidation($user->id);
            $mailer->sendResetPasswordMail($user, $resetToken);

            echo json_encode(['state'=>'ok']);

        }
        return null;
    }
    public function resetPassword(string $slug_token)
    {
        $auth = new Authentification();

        $userId = $auth->Validate_jwt($slug_token)['Jwt']['dcpl']['userId']??null;
        $userManager = new UserManager();
        if ($userId) {
            $user = $userManager->find($userId);
        }
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            if ($user) {
                return $this->renderView("resetPasswordEmail.php", ['state' => 'Ok']);

            }
            return $this->renderView("expiredLink.php", ['state' => 'Token is expired']);
        }
        if ($user) {
            $newPassword = json_decode(file_get_contents('php://input'), true)['newPassword'];
            $user->password = hash('sha512', $newPassword);
            $userManager->edit($user);
            echo json_encode(['state' => 'Ok']);
            return null;
        }
        echo json_encode(['state' => 'Token is expired']);
        return null;

    }

    public function changePassword()
    {   
        $user = $this->getCurrentUser();
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            if ($user) {
                return $this->renderView("changePassword.php");
            }
            return $this->redirectToRoute('signin');
        }
        $data = json_decode(file_get_contents('php://input'), true); #json ['email':'email','password':'password','newPassword':'newPassword']
        $userManager = new UserManager();
        if ($user&&$user->method=="NATIVE") {
        if (!$this->verifyPassword($user, $data['password'])) {
            echo json_encode(['state' => 'Invalid Password']);
            return null;
        } else {
            $user->password = hash('sha512', $data['newPassword']);
            $userManager->edit($user);
            echo json_encode(['state' => 'Ok']);
            return null;
        }
    } else {
        exit;
    }
    }

    public function googleSignin()
    {
        $googleOauth = new GoogleOAuth();
        $data = $googleOauth->googleConnect("googleSignin");
        if (isset($data)) {
            $userManager = new UserManager();
            $user = $userManager->findOneByEmail($data['email']);
            if (isset($user) && $user->method == 'GOOGLE') {
                $auth = new Authentification();
                if ($user->verified) {
                    session_regenerate_id(true);
                    $_SESSION['token'] = $auth->Gen_jwt($user->id);
                    if ($data['firstName']!=$user->firstName||$data['lastName']!=$user->lastName||$data['avatarUrl']!=$user->avatarUrl) {
                        $user->firstName=$data["firstName"];
                        $user->lastName=$data['lastName'];
                        $user->avatarUrl=$data['avatarUrl'];
                        $userManager->edit($user);
                    }

                    $_SESSION['url']=$user->avatarUrl;

                    echo json_encode(["state" => "Connected"]);
                    return $this->redirectToRoute('');

                } else {
                    $mailer = new Mailer();
                    $verificationToken = $auth->genJwtForEmailValidation($user->id);
                    $mailer->sendEmailVerificationMail($user, $verificationToken);
                    echo json_encode(["state" => "Email is not verified"]);
                    return null;
                }
            } else {
                echo json_encode(['state' => "User doesn't exist or invalid connection method"]);
            }
        }
    }
    public function googleSignup()
    {
        $googleOauth = new GoogleOAuth();
        $data = $googleOauth->googleConnect("googleSignup");
        if (isset($data)) {
            $userManager = new UserManager();
            $user = $userManager->findOneByEmail($data['email']);
            if (!$user) {
                $user = new User();
                $user->firstName = $data['firstName'];
                $user->lastName = $data['lastName'];
                $user->email = $data['email'];
                $user->password = "";
                $user->method = "GOOGLE";
                $userId = $userManager->add($user);

                #Envoie du mail de vérification
                $mailer = new Mailer();
                $auth = new Authentification();
                $verificationToken = $auth->genJwtForEmailValidation($userId);

                $mailer->sendEmailVerificationMail($user, $verificationToken);
                return $this->redirectToRoute('signin');
            } else {

                if ($user->method=="GOOGLE") {
                    $auth = new Authentification();
                if ($user->verified) {
                    session_regenerate_id(true);
                    $_SESSION['token'] = $auth->Gen_jwt($user->id);
                    if ($data['firstName']!=$user->firstName||$data['lastName']!=$user->lastName||$data['avatarUrl']!=$user->avatarUrl) {
                        $user->firstName=$data["firstName"];
                        $user->lastName=$data['lastName'];
                        $user->avatarUrl=$data['avatarUrl'];
                        $userManager->edit($user);
                    }
                    $_SESSION['url']=$user->avatarUrl;
                    echo json_encode(["state" => "Connected"]);
                    return $this->redirectToRoute('');

                } else {
                    $mailer = new Mailer();
                    $verificationToken = $auth->genJwtForEmailValidation($user->id);
                    $mailer->sendEmailVerificationMail($user, $verificationToken);
                    echo json_encode(["state" => "Email is not verified"]);
                    return null;
                }
                }

                echo json_encode(["state" => "This email is already being used"]);
                return null;
            }
        }
    }

}

