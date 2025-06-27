<?php require_once(__DIR__ . '/../../utils.php'); // Adicione esta linha

use App\HTTP\Request;
use App\HTTP\Response;
use App\Controllers\AdminController;
use App\Controllers\AdminNoticiasController;
use App\Controllers\AdminEducadoresController;
use App\Controllers\AdminLTDController;
use App\Controllers\AdminAtleticaController; // ADICIONE ESTA LINHA

$router->get('/admin', [
    fn() => new Response(200, (new AdminController())->index())
]);


// Grupo de rotas para o painel de administração de notícias
$router->get('/admin/noticias', [
    fn(Request $request) => new Response(200, (new AdminNoticiasController())->index($request))
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
    fn($request, $params) => (new AdminNoticiasController())->destroy($request, $params)
]);


// Novas rotas para o painel de administração de EDUCADORES
$router->get('/admin/educadores', [
    fn(Request $request) => (
        new Response(200, (new AdminEducadoresController())->index($request))
    )
]);

$router->get('/admin/educadores/create', [
    fn() => new Response(200, (new AdminEducadoresController())->create())
]);

$router->post('/admin/educadores/create', [
    fn(Request $request) => (new AdminEducadoresController())->store($request)
]);

$router->get('/admin/educadores/edit/{id}', [
    fn(Request $request, $params) => new Response(200, (new AdminEducadoresController())->edit($request, $params))
]);

$router->post('/admin/educadores/edit/{id}', [
    fn(Request $request, $params) => (new AdminEducadoresController())->update($request, $params)
]);

$router->get('/admin/educadores/delete/{id}', [
    fn(Request $request, $params) => new Response(200, (new AdminEducadoresController())->delete($request, $params))
]);

$router->post('/admin/educadores/delete/{id}', [
    fn(Request $request, $params) => (new AdminEducadoresController())->destroy($request, $params)
]);


// Rota para o painel de administração de projetos LTD
$router->get('/admin/ltd', [
    fn($request, $params) => new Response(200, (new AdminLTDController())->index($request, $params))
]);


$router->get('/admin/ltd/create', [
    fn($request, $params) => new Response(200, (new AdminLTDController())->create($request, $params))
]);

$router->post('/admin/ltd/create', [
    fn(Request $request) => (new AdminLTDController())->store($request)
]);

$router->get('/admin/ltd/edit/{id}', [
    fn(Request $request, $params) => new Response(200, (new AdminLTDController())->edit($request, $params))
]);

$router->post('/admin/ltd/edit/{id}', [
    fn(Request $request, $params) => (new AdminLTDController())->update($request, $params)
]);

$router->get('/admin/ltd/delete/{id}', [
    fn(Request $request, $params) => new Response(200, (new AdminLTDController())->delete($request, $params))
]);

$router->post('/admin/ltd/delete/{id}', [
    fn(Request $request, $params) => (new AdminLTDController())->destroy($request, $params)
]);


// NOVAS ROTAS PARA O PAINEL DE ADMINISTRAÇÃO DA ATLÉTICA
$router->get('/admin/atletica', [
    fn(Request $request) => new Response(200, (new AdminAtleticaController())->index($request))
]);

$router->get('/admin/atletica/create', [
    fn() => new Response(200, (new AdminAtleticaController())->create())
]);

$router->post('/admin/atletica/create', [
    fn(Request $request) => (new AdminAtleticaController())->store($request)
]);

$router->get('/admin/atletica/edit/{id}', [
    fn(Request $request, $params) => new Response(200, (new AdminAtleticaController())->edit($request, $params))
]);

$router->post('/admin/atletica/edit/{id}', [
    fn(Request $request, $params) => (new AdminAtleticaController())->update($request, $params)
]);

$router->get('/admin/atletica/delete/{id}', [
    fn(Request $request, $params) => new Response(200, (new AdminAtleticaController())->delete($request, $params))
]);

$router->post('/admin/atletica/delete/{id}', [
    fn(Request $request, $params) => (new AdminAtleticaController())->destroy($request, $params)
]);