<?php

return [

    'login' => function ($req, $res) {
        $res->send('login');
    },

    'register' => function ($req, $res) {
        $res->send('register');
    },

    'authorization' => function ($req, $res) {
        $q = &$req->query;

        if(!isset($q['auth'])) {
            $res->status(403)->json(['messageError' => 'paramètre d\'authentification "auth" introuvable !']);
        }

        if ($q['auth'] != 'gaetant') {
            $res->status(403)->json(['messageError' => 'échec d\'authentification !']);
        }
    },

    'getUser' => function ($req, $res) {
        $res->json(['data'=>$req->params]);
    }

];