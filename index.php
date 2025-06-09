<?php
require_once(__DIR__."/vendor/autoload.php");

use App\HTTP\Router;
use App\Utils\Config;
use App\Database\Database;


define('URL',Config::get('app/url')); 
define('ROOT_PATH', __DIR__);
define("BASE_URL",dirname($_SERVER['PHP_SELF']));
Database::config(
    Config::get('database/host'),
    Config::get('database/name'),
    Config::get('database/user'),
    Config::get('database/password'),
    Config::get('database/port')
);


$router = new Router(URL);
//carregando as rotas
include_once(__DIR__."/src/routers/web.php");

$router->run()
    ->sendResponse();
?>