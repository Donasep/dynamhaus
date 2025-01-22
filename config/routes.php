<?php
const ROUTES = [
    '/' => [
        'controller' => App\Controllers\FrontOffice\AdController::class,
        'method' => 'home',
    ],
    '/search'=> [
        'controller' => App\Controllers\FrontOffice\AdController::class,
        'method' => 'search',
    ],
    '/addAd'=> [
        'controller' => App\Controllers\FrontOffice\AdController::class,
        'method'=>'addAd'
    ],
    '/signup'=> [
        'controller' => App\Controllers\FrontOffice\AuthController::class,
        'method'=>'signup'
    ],
    '/signin'=> [
        'controller' => App\Controllers\FrontOffice\AuthController::class,
        'method'=>'signin'
    ],
    '/cgu' => [
        'controller' => App\Controllers\FrontOffice\ArticleController::class,
        'method' => 'cgu',
    ],
    '/faq' => [
        'controller' => App\Controllers\FrontOffice\ArticleController::class,
        'method' => 'faq',
    ],
    '/lgt' => [
        'controller' => App\Controllers\FrontOffice\ArticleController::class,
        'method' => 'lgt',
    ],

    '/annonce/{slug_id}'=> [
        'controller' => App\Controllers\FrontOffice\AdController::class,
        'method'=>'singleAd'
    ],
    '/signout' => [
        'controller' => App\Controllers\FrontOffice\AuthController::class,
        'method'=>'signout'
    ],
    '/verifyAccount/{slug_token}'=> [
        'controller' => App\Controllers\FrontOffice\AuthController::class,
        'method'=>'verifyAccount'
    ],
    '/resetPassword/{slug_token}'=> [
        'controller' => App\Controllers\FrontOffice\AuthController::class,
        'method'=>'resetPassword'
    ],
    '/resetPassword'=> [
        'controller' => App\Controllers\FrontOffice\AuthController::class,
        'method'=>'sendResetPasswordMail'
    ],
    '/changePassword'=> [
        'controller' => App\Controllers\FrontOffice\AuthController::class,
        'method'=>'changePassword'
    ],
    '/googleSignin'=> [
        'controller' => App\Controllers\FrontOffice\AuthController::class,
        'method'=>'googleSignin'
    ],
    '/googleSignup'=> [
        'controller' => App\Controllers\FrontOffice\AuthController::class,
        'method'=>'googleSignup'
    ],
    '/user/updateFavorite/{slug_id}'=> [
        'controller' => App\Controllers\FrontOffice\AdController::class,
        'method'=>'updateFavorite'
    ],
    '/modifyAd/{slug_id}' => [
        'controller' => App\Controllers\FrontOffice\AdController::class,
        'method'=>'modifyAd'
    ],
    '/profile' => [
        'controller' => App\Controllers\FrontOffice\UserController::class,
        'method'=>'getProfile'
    ],
    '/createArticle/{slug_type}' => [
        'controller' => App\Controllers\FrontOffice\ArticleController::class,
        'method'=>'createArticle'
    ],
    '/contact/postContact'=> [
        'controller' => App\Controllers\FrontOffice\ContactController::class,
        'method'=>'postContact'
    ],
    '/contact/deleteContact/{slug_id}'=> [
        'controller' => App\Controllers\FrontOffice\ContactController::class,
        'method'=>'deleteContact'
    ],
    '/contact/getContacts'=> [
        'controller' => App\Controllers\FrontOffice\ContactController::class,
        'method'=>'getContacts'
    ],
    '/contact/readContact/{slug_id}'=> [
        'controller' => App\Controllers\FrontOffice\ContactController::class,
        'method'=>'readContact'
    ],
    '/article/createArticle/{slug_type}'=> [
        'controller' => App\Controllers\FrontOffice\ArticleController::class,
        'method'=>'createArticle'
    ],
    '/article/deleteArticle/{slug_id}'=> [
        'controller' => App\Controllers\FrontOffice\ArticleController::class,
        'method'=>'deleteArticle'
    ],
    '/report/{slug_id}'=> [
        'controller' => App\Controllers\FrontOffice\AdController::class,
        'method'=>'updateReport'
    ],

];
