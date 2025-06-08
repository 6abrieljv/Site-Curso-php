<?php
require_once(__DIR__."/vendor/autoload.php");
use App\HTTP\Response;

$ob = new Response(200, "<h1>Olá Mundo!</h1>", "text/html");

$ob->sendResponse();



exit;


?>