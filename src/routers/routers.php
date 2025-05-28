
<?php
$routes = [
    "/"=> "HomeController@index",
    "/ltd"=>"LTDController@show",
    "/podpink"=> "PodPinkController@show",
    "/educadores"=>"EducadoresController@show",
    "/atletica"=>"AtleticaController@show",
    "/profile"=>"ProfileController@show",

    "/login"=> "LoginController@show",
    "logout"=> "LoginController@logout",
    "/login/submit"=> "LoginController@login",
    "/register"=> "RegisterController@show",
    
];

return $routes;
?>