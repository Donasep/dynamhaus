<?php
namespace App\Controllers;

use App\Lib\Controller\AbstractController;
class HomeController extends AbstractController {
    public function home () {
        
        return $this->renderView("accueil.php");
    }
}