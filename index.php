<?php
require_once(__DIR__."/vendor/autoload.php");

use App\Controllers\HomeController;
use App\HTTP\Response;
use App\HTTP\Router;

define('URL', 'http://localhost/code/Site-Curso-php/');
define('ROOT_PATH', __DIR__);
define("BASE_URL",dirname($_SERVER['PHP_SELF']));


$router = new Router(URL);
//carregando as rotas
include_once(__DIR__."/src/routers/web.php");

$router->run()
    ->sendResponse();
?>