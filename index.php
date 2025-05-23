<?php

define('ROOT_PATH', __DIR__);
define('ROOT_URL', 'http://localhost/code/Site-Curso-php');
require_once(ROOT_PATH."/vendor/autoload.php");

spl_autoload_register(function ($file) {
    if(file_exists(ROOT_PATH."/src/utils/$file.php")) {
        require_once(ROOT_PATH."/src/utils/$file.php");
    }else if(file_exists(ROOT_PATH."/src/model/$file.php")){
        require_once(ROOT_PATH."/src/model/$file.php");
    }
});
// Define ROOT_PATH directly or retrieve it from a configuration file or environment variable

$routers = require_once(ROOT_PATH."/src/routers/routers.php");


require_once(ROOT_PATH."/src/core/Core.php");


$core = new Core($routers);

$core->run();

?>