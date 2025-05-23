
<?php
$routes = [
    "/"=> "HomeController@index",

    "/atletica"=>"AtleticaController@show",
    "/ltd"=>"LTDController@show",
    "/profile"=>"ProfileController@show",

    "/login"=> "LoginController@show",
    "logout"=> "LoginController@logout",
    "/login/submit"=> "LoginController@login",
    "/register"=> "RegisterController@show",
    
];

return $routes;
?>