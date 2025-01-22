<?php
namespace App\Controllers\FrontOffice;
use App\Lib\Controller\AbstractController;
class FaqController extends AbstractController {
    public function home() {

        return $this->renderView('contactUs.php');

    }
}