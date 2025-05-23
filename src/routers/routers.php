
<?php
$routes = [
    "/"=> "HomeController@index",

    "/atletica"=>"AtleticaController@show",
    "/educadores"=>"EducadoresController@show",
    "/ltd"=>"LTDController@show",
    "/profile"=>"ProfileController@show",

    "/login"=> "LoginController@show",
    "logout"=> "LoginController@logout",
    "/login/submit"=> "LoginController@login",
    "/register"=> "RegisterController@show",
    
];

return $routes;
?>