<?php

use App\Controllers\AuthController;

$router->get('/login', [ fn() => (new AuthController())->showLoginForm() ]);
$router->post('/login', [ fn( $r) => (new AuthController())->login($r) ]);
$router->get('/register', [ fn() => (new AuthController())->showRegisterForm() ]);
$router->post('/register', [ fn( $r) => (new AuthController())->register($r) ]);
$router->get('/logout', [ fn() => (new AuthController())->logout() ]);

