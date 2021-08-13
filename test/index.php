<?php

use melody\main\Main;

include __DIR__ . DIRECTORY_SEPARATOR . "init" . DIRECTORY_SEPARATOR . "init.php";

$userCtrl = include ROOT . DS . "controlers/userCtrl.php";

// echo "&rsaquo;"

$app = new Main('q');

$app->get('/', function ($req, $res) {
    $res->send('<h1 style="tesxt-alig:center">home page</h1>');
});

$app->get("/user/login", $userCtrl['login']);

$app->get("/user/register", $userCtrl['register'] );

$app->default(function ($req, $res) {
    $res->status(404)
        ->send('<h1 style="text-align:center">404 no found !</h1> <p style="text-align:center"><a href="http://localhost/melody/test/?q=/">accueil</a></p>');
});

$app->end();