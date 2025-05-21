
<?php
$routes = [
    "/"=> "HomeController@index",
    "/login"=> "LoginController@show",
    "/register"=> "RegisterController@show",
    "/atletica"=>"AtleticaController@show",
    "/educadores"=>"EducadoresController@show",
    "/ltd"=>"LTDController@show",
    "/profile"=>"ProfileController@show"
];

return $routes;
?>