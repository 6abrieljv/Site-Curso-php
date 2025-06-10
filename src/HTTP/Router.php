<?php

namespace App\HTTP;

use \Closure;
use Exception;
use App\HTTP\Request;
use App\HTTP\Response;
use App\Controllers\ErrorController;
use ReflectionFunction;

class Router
{
    private $url = '';
    private $prefix = '';
    private $routes = [];
    private $request;

    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    private function setPrefix()
    {
        $this->prefix = parse_url($this->url, PHP_URL_PATH) ?? '';
    }

    public function addRoute(string $method, string $route, array $params = [])
    {
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $params['variables'] = [];
        $patternVariable = '/\{([a-zA-Z0-9_]+)\}/'; // Permitindo underline também
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '([a-zA-Z0-9\-_]+)', $route);
            $params['variables'] = $matches[1];
        }

        $pattern = '/^' . str_replace('/', '\/', $route) . '$/';
        $this->routes[$pattern][$method] = $params;
    }

    // Métodos get, post, put, delete, patch (sem alterações)
    public function get($router, $params = [])
    {
        $this->addRoute('GET', $router, $params);
    }
    public function post($router, $params = [])
    {
        $this->addRoute('POST', $router, $params);
    }
    public function put($router, $params = [])
    {
        $this->addRoute('PUT', $router, $params);
    }
    public function delete($router, $params = [])
    {
        $this->addRoute('DELETE', $router, $params);
    }
    public function patch($router, $params = [])
    {
        $this->addRoute('PATCH', $router, $params);
    }


    private function getUri()
    {
        $uri = $this->request->getUri();
        $uriPath = parse_url($uri, PHP_URL_PATH);
        $prefix = rtrim($this->prefix, '/');
        $uriWithoutPrefix = '';
        if (strlen($prefix) > 0 && strpos($uriPath, $prefix) === 0) {
            $uriWithoutPrefix = substr($uriPath, strlen($prefix));
        } else {
            $uriWithoutPrefix = $uriPath;
        }
        return '/' . trim($uriWithoutPrefix, '/');
    }

    private function getRoute()
    {
        $uri = $this->getUri();
        $httpMethod = $this->request->getMethod();

        foreach ($this->routes as $patternRoute => $methods) {
            // MUDANÇA AQUI 1: Adicionamos a variável $matches para capturar os valores
            if (preg_match($patternRoute, $uri, $matches)) {
                if (isset($methods[$httpMethod])) {
                    // MUDANÇA AQUI 2: Processar as variáveis capturadas
                    // Remove o primeiro elemento de $matches, que é a URI completa
                    array_shift($matches);

                    $routeParams = $methods[$httpMethod];

                    // Combina os nomes das variáveis com os valores capturados
                    if (!empty($routeParams['variables']) && !empty($matches)) {
                        $routeParams['params'] = array_combine($routeParams['variables'], $matches);
                    } else {
                        $routeParams['params'] = [];
                    }

                    return $routeParams; // Retorna a rota com os parâmetros já processados
                }
                throw new Exception("Método não permitido", 405);
            }
        }
        throw new Exception("Página não encontrada", 404);
    }

    public function run()
    {
        try {
            $route = $this->getRoute(); // $route agora contém 'params'
            if (!isset($route['controller']) || !$route['controller'] instanceof Closure) {
                throw new Exception("Controller não definido", 500);
            }

            $controller = $route['controller'];
            $reflection = new ReflectionFunction($controller);

            // MUDANÇA AQUI 3: Passamos o array de parâmetros como segundo argumento
            $args = [$this->request, $route['params']];

            return $reflection->invokeArgs($args);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            $errorMessage = $e->getMessage() ?: 'Erro interno do servidor';
            $errorController = new ErrorController();
            $errorResponse = $errorController->renderError(['message' => $errorMessage, 'code' => $statusCode]);
            return new Response($statusCode, $errorResponse);
        }
    }
}
