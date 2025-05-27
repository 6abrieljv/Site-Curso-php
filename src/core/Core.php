<?php
class Core
{

    private $routers;

    public function __construct($routers)
    {
        $this->routers = $routers;
    }


    public function run()
    {
        $url = "/";
        isset($_GET['url']) ? $url .= $_GET['url'] : '';
        ($url !='/')? $url = rtrim($url, '/'): $url;

        $routerFound = false;
        foreach ($this->routers as $path => $controller) {

            // montando expressão regular
            $pattern = "#^" . preg_replace('/{id}/', '(\w+)', $path) . '$#';
            

            
            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                $routerFound = true;
                [$currentController, $action] = explode('@', $controller);

                require_once __DIR__ . "/../controllers/$currentController.php";
                (new $currentController())->$action();
            }
        }
        if (!$routerFound) {
            require_once __DIR__."/../controllers/NotFoundController.php";
            $notFound = new NotFoundController();
            $notFound->show();
            
        }
    }
}
