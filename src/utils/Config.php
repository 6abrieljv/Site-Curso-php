<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class Config
{
    private static $instance = null;
    private $data = [];

    private function __construct()
    {
        $dotenv = parse_ini_file('.env', true);
        if ($dotenv === false) {
            throw new Exception('Failed to load .env file');
        }

        // configurações extras, se quiser
        $this->data['paths'] = [
            'root' => $_SERVER['DOCUMENT_ROOT'],
            'assets' => '/public/assets',
            'css' => '/public/assets/css',
            'js' => '/public/assets/js',
            'img' => '/public/assets/img',
        ];
    }

    public static function getInstance(): Config
    {
        if (!self::$instance) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    public function get(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $value = $this->data;

        foreach ($keys as $segment) {
            if (!isset($value[$segment])) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }
}
