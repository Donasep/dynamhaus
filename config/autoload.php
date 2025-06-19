<?php
spl_autoload_register(function (string $class) {

    $namespaceParts = explode('\\', $class);

    $filepath = dirname(__DIR__). '/' . implode('/',$namespaceParts) . ".php";
    if (!file_exists($filepath)) {
        throw new Exception("Fichier ".$filepath." est introuvable pour la classe ".$class);
    }
    require $filepath;
});