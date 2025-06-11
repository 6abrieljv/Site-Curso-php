<?php

use App\Controllers;
use App\HTTP\Response;


$router->get(
    '/login',
    [
        fn() => new Response(200, (new Controllers\AuthController())->show())

    ]

);
$router->post(
    '/login',
    [
        fn() => new Response(200,(new Controllers\AuthController())->login())
    ]
    );