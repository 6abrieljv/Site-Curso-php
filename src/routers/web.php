<?php
// rotas das paginas web

use App\Controllers;
use App\HTTP\Response;

$router->get('/', [
    function () {

        return new Response(200, (new Controllers\HomeController())->index());
    }
]);

$router->get('/ltd', [
    function () {

        return new Response(200, (new Controllers\LTDController())->index());
    }
]);
$router->get('/atletica', [
    function () {

        return new Response(200,(new Controllers\AtleticaController())->index());
    }
]);

$router->get('/noticias', [
    function () {

        return new Response(200,(new Controllers\NoticiasController())->index());
    }
]);
$router->get('/educadores', [
    function () {

        return new Response(200,(new Controllers\EducadoresController())->index());
    }
]);


$router->get('/podpink', [
    function () {

        return new Response(200,(new Controllers\PodPinkController())->index());
    }
]);


