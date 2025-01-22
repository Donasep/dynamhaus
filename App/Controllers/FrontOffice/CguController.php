<?php
namespace App\Controllers\FrontOffice;
use App\Lib\Controller\AbstractController;
class CGUController extends AbstractController {
    public function home() {
        return $this->renderView('cgu.php');
    }
}