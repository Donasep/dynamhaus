<?php
error_log("INDEX.PHP: Entrée. REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'Non défini'));
error_log("INDEX.PHP: \$_GET contenu: " . print_r($_GET, true));

require __DIR__."/config/autoload.php";
use App\Lib\Router\Router;
session_start();
new Router();