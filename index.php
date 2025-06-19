<?php
require __DIR__."/config/autoload.php";
use App\Lib\Router\Router;
session_start();
new Router();