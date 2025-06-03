
<?php
$routes = [
    "/"=> "HomeController@index",
    "/ltd"=>"LTDController@show",
    "/podpink"=> "PodPinkController@show",
    "/educadores"=>"EducadoresController@show",
    "/atletica"=>"AtleticaController@show",
    "/noticias" => "NoticiasController@index",

    "/login"=> "LoginController@show",
    "logout"=> "LoginController@logout",
    "/login/submit"=> "LoginController@login",
    "/register"=> "RegisterController@show",
    "/profile"=>"ProfileController@show",
];

return $routes;
?>