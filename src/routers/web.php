<?php
// ... (código existente) ...

use App\Controllers; // Certifique-se de que esta linha está presente
use App\HTTP\Response; // Certifique-se de que esta linha está presente
use App\HTTP\Request; // **ADICIONE ESTA LINHA**

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
        return new Response(200, (new Controllers\AtleticaController())->index());
    }
]);

$router->get('/noticias', [
    function ($request) {
        return new Response(200, (new Controllers\NoticiasController())->index($request));
    }
]);
$router->get('/noticia/{slug}', [
    function ($request,$params) {      
        return new Response(200, (new Controllers\NoticiasController())->show($request, $params));
    }
]);

$router->get('/educadores', [ // Linha da rota para /educadores
    function (Request $request) { // <-- MUDANÇA AQUI: Adicionar 'Request $request'
        return new Response(200, (new Controllers\EducadoresController())->index($request)); // <-- MUDANÇA AQUI: Passar '$request' para o index()
    }
]);


$router->get('/podpink', [
    function () {
        return new Response(200, (new Controllers\PodPinkController())->index());
    }
]);


$router->get('/perfil', [
    fn() => new Response(200,(new Controllers\PerfilController())->index())
]);
$router->post('/perfil', [
    fn($request) => new Response(200,(new Controllers\PerfilController())->update($request))

]);

$router->get('/sobre', [
    fn() => new Response(200,(new Controllers\SobreController())->index())
]);