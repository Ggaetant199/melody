<?php

use melody\main\Main;

include __DIR__ . DIRECTORY_SEPARATOR . "init" . DIRECTORY_SEPARATOR . "init.php";

// Importation du user controler
$userCtrl = include ROOT . DS . "controlers/userCtrl.php";

// Instantiation de l'application

$app = new Main();

// middlewares


$app->get(uri('/'), function ($req, $res) {
    $res->send('<h1 style="text-align:center">home page</h1>');
})

->get(uri("/getUser/:idUser"), [
    $userCtrl['authorization'], 
    $userCtrl['getUser']
])

->get(uri('/download'), function ($req, $res) {
    
    if (! $res->download('index.php')) {
        $res->send('erreur impossible de télécharger la ressource !');
    }
})

->get(uri("/user/login"), $userCtrl['login'])

->get(uri("/user/register"), $userCtrl['register'])

->default(function ($req, $res) {
    $res->status(404)->send('<h1 style="text-align:center">404 no found !</h1> <p style="text-align:center"><a href="http://' . HOST . '/melody/test/?q=/">accueil</a></p>');
})

->end(); // terminaison de l'application