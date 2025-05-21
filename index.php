<?php
require_once(__DIR__."/vendor/autoload.php");


spl_autoload_register(function ($file) {
    if(file_exists(__DIR__."/src/utils/$file.php")) {
        require_once(__DIR__."/src/utils/$file.php");
}else if(file_exists(__DIR__."/src/model/$file.php")){
    require_once(__DIR__."/src/model/$file.php");
}
});

$routers = require_once(__DIR__."/src/routers/routers.php");


require_once(__DIR__."/src/core/Core.php");

$core = new Core($routers);

$core->run();

?>