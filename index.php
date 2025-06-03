<?php

require_once(__DIR__."/vendor/autoload.php");
define('ROOT_PATH', __DIR__);
define("BASE_URL",dirname($_SERVER['PHP_SELF']));



spl_autoload_register(function ($file) {
    if(file_exists(ROOT_PATH."/src/utils/$file.php")) {
        require_once(ROOT_PATH."/src/utils/$file.php");
    }else if(file_exists(ROOT_PATH."/src/models/$file.php")){
        require_once(ROOT_PATH."/src/models/$file.php");
    }
    else if(file_exists(ROOT_PATH."/src/repositories/$file.php")){
        require_once(ROOT_PATH."/src/repositories/$file.php");
    }
});
// Define ROOT_PATH directly or retrieve it from a configuration file or environment variable
$routers = require_once(ROOT_PATH."/src/routers/routers.php");
require_once(ROOT_PATH."/src/core/Core.php");
(new Core($routers))->run();

?>