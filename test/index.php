<?php

use melody\main\Main;

include __DIR__ . DIRECTORY_SEPARATOR . "init" . DIRECTORY_SEPARATOR . "init.php";

// Importation du user controler
$userCtrl = include ROOT . DS . "controlers/userCtrl.php";

// Instantiation de l'application

$app = new Main('q'); // 'q' est le nom du paramètre get qui contient la requête à analyser

// middlewares

$app->get('/', function ($req, $res) {
    $res->send('<h1 style="tesxt-alig:center">home page</h1>');
});

$app->get("/user/login", $userCtrl['login']);

$app->get("/user/register", $userCtrl['register'] );

$app->default(function ($req, $res) {
    $res->status(404)
        ->send('<h1 style="text-align:center">404 no found !</h1> <p style="text-align:center"><a href="http://localhost/melody/test/?q=/">accueil</a></p>');
});

$app->end(); // terminaison de l'application
