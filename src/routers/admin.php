<?php

use App\HTTP\Request;
use App\HTTP\Response;
use App\Controllers\AdminController;
use App\Controllers\AdminNoticiasController;

$router->get('/admin', [
    fn() => new Response(200, (new AdminController())->index())
]);


// Grupo de rotas para o painel de administração de notícias
$router->get('/admin/noticias', [
    fn() => new Response(200, (new AdminNoticiasController())->index())
]);

$router->get('/admin/noticias/create', [
    fn() => new Response(200, (new AdminNoticiasController())->create())
]);

$router->post('/admin/noticias/create', [
    fn(Request $request) => (new AdminNoticiasController())->store($request)
]);

$router->get('/admin/noticias/edit/{id}', [
    fn($request, $params) => new Response(200, (new AdminNoticiasController())->edit($request, $params))
]);

$router->post('/admin/noticias/edit/{id}', [
    fn(Request $request, $id) => (new AdminNoticiasController())->update($request, $id)
]);

$router->get('/admin/noticias/delete/{id}', [
    fn($request,$params) => new Response(200, (new AdminNoticiasController())->delete($request,$params))
]);

$router->post('/admin/noticias/delete/{id}', [
    fn($request, $params) => new Response(200, (new AdminNoticiasController())->destroy($request, $params))
]);