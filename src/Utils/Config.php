<?php
namespace App\Utils;
// carregando .env
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Definindo constantes de ambiente
$GLOBALS['config'] = array(
    'database' => array(
        'host' => $_ENV['DB_HOST'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'name' => $_ENV['DB_NAME'],
        'port' => $_ENV['DB_PORT'],
        'charset' => $_ENV['DB_CHARSET'],
        'DB_DRIVER' => $_ENV['DB_DRIVER'],
    ),
    'app'=> array(
        'name' => $_ENV['APP_NAME'],
        'url' => $_ENV['APP_URL'],
        'debug' => filter_var($_ENV['APP_DEBUG'], FILTER_VALIDATE_BOOLEAN),
    ),
);

class Config
{
    public static function get($key = null)
    {
        $keys = explode("/", $key);
        $tmpref = &$GLOBALS['config'];
        $return = null;
        while ($key = array_shift($keys)) {
            if (array_key_exists($key, $tmpref)) {
                $return = $tmpref[$key];
                $tmpref = &$tmpref[$key];
            } else {
                return null; //not found
            }
        }
        return $return; //found
    }
}
