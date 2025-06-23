<?php

use App\Repositories\CategoriaRepository;

require_once(__DIR__ . "/vendor/autoload.php");

use App\HTTP\Router;
use App\Utils\Config;
use App\Database\Database;
use App\Models\Noticia;

use App\Repositories\NoticiaRepository;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// define('URL', Config::get('app/url'));
define('URL', Config::get('app/url'));
define('ROOT_PATH', __DIR__);
define("BASE_URL", dirname($_SERVER['PHP_SELF']));
session_start();

Database::config(
    Config::get('database/host'),
    Config::get('database/name'),
    Config::get('database/username'),
    Config::get('database/password'),
    Config::get('database/port'),
    Config::get('database/charset') // Adicionar charset
);



$router = new Router(URL);
//carregando as rotas
include_once(__DIR__ . "/src/routers/web.php");
include_once(__DIR__ . "/src/routers/admin.php");
include_once(__DIR__ . "/src/routers/auth.php");

$router->run()
    ->sendResponse();
