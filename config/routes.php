<?php
const ROUTES = [
    '/inscription' => [
        'controller' => App\Controllers\AuthController::class,
        'method' => 'signup',
    ],
    '/'=> [
        'controller' => App\Controllers\HomeController::class,
        'method' => 'home',
    ],
    '/login' => [
        'controller' => App\Controllers\AuthController::class,
        'method' => 'signin',
    ],
    '/signout'=> [
        'controller' => App\Controllers\AuthController::class,
        'method' => 'signout',
    ],
    '/temperature'=>[
        'controller' => App\Controllers\SensorDataController::class,
        'method' => 'temperature',
    ],
    '/gestion'=>[
        'controller' => App\Controllers\SensorParamController::class,
        'method' => 'gestion',
    ],
    '/api/device/update-period' => [ 
        'controller' => App\Controllers\SensorParamController::class,
        'method' => 'updateSamplingPeriod',
    ],
    '/api/device/toggle-status' => [ 
        'controller' => App\Controllers\SensorParamController::class,
        'method' => 'toggleDeviceStatus',
    ],
        '/profil' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'showProfile'
    ],
    '/profil/edit' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'editProfile'
    ],
    '/profil/update' => [
        'controller' => App\Controllers\UserController::class,
        'method' => 'updateProfile'
    ],
    '/lumiere' => [ // URL pour la page dashboard
        'controller' => App\Controllers\SensorDataController::class,
        'method' => 'lumiere',
    ],
    '/api/light/current' => [ // Endpoint pour la donnée actuelle
        'controller' => App\Controllers\SensorDataController::class,
        'method' => 'getCurrentLightDataAjax',
    ],
    '/api/light/history' => [ // Endpoint pour l'historique du graphique
        'controller' => App\Controllers\SensorDataController::class,
        'method' => 'getLightHistoryAjax',
    ],
    '/api/light/lux-hours' => [
        'controller' => App\Controllers\SensorDataController::class,
        'method' => 'getLuxHoursAjax',
    ],
    '/api/light/events' => [
        'controller' => App\Controllers\SensorDataController::class,
        'method' => 'getLightEventsAjax',
    ],
];
