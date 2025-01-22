<?php 

use App\Controllers\FrontOffice\UserController;
use App\Lib\Mailer\Mailer;
use App\Models\Entity\User;
use App\Models\Manager\AdManager;
use App\Models\Manager\UserManager;

//Lancement de l'autoloader global
require __DIR__."/config/autoload.php";

#Create Session
session_start();

// Autoloader de composer
if (file_exists("vendor/autoload.php")) {
    require_once("vendor/autoload.php");
}
#Loading dotenv in environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv -> safeLoad();


#Load router
use App\Lib\Router\Router;
new Router();

/*
$Mailer = new Mailer();
$Mailer->mail("donaflipo@gmail.com","verification","Verify your email","http://localhost/Old/dynmahaus/index.php?path=/search","JAJ");
    */
/*
$userManager = new UserManager();
$user = new User();
$user->email="jaj1@gmail.com";
$user->firstName="Prénom";
$user->lastName="Nom";
$user->password="password";
$user->verified=false;
$user=$userManager->add($user);
foreach($users as $user) {
    foreach($user as $key => $param) {
        echo $key." => ".$param;
    }
}
*/

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
/*
$Mailer = new Mailer();
$Mailer->mail("donaflipo@gmail.com","verification","Verify your email","http://localhost/Old/dynmahaus/index.php?path=/search","JAJ");
    */
/*
$userManager = new UserManager();
$user = new User();
$user->email="jaj1@gmail.com";
$user->firstName="Prénom";
$user->lastName="Nom";
$user->password="password";
$user->verified=false;
$user=$userManager->add($user);
foreach($users as $user) {
    foreach($user as $key => $param) {
        echo $key." => ".$param;
    }
}
*/


/*use App\Lib\Authentification\Authentification;
$authentification = new Authentification();
$payload=55555;
$Jwt=$authentification->gen_jwt($payload);

$decodedJwt=$authentification->decode_jwt($Jwt);
foreach($decodedJwt as $p) {
    foreach($p as $u) {
        echo $u;
    }
}
*/