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
        // adiciona a rota a coleção de rotas
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
            }
        }

        $params['variables'] = [];
        $patternVariable = '/\{([a-zA-Z0-9]+)\}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '([a-zA-Z0-9\-_]+)', $route);
            $params['variables'] = $matches[1]; // Salva os nomes das variáveis (ex: 'slug', 'username')
        }
        // Verifica se o método é válido
        $pattern = '/^' . str_replace('/', '\/', $route) . '$/';

        $this->routes[$pattern][$method] = $params;
    }

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
        // Obtém a URL atual
        $uri = $this->request->getUri();

        // Obtém o caminho da URL
        $uriPath = parse_url($uri, PHP_URL_PATH);

        // Adiciona debug temporário
        echo "<!-- URI original: {$uriPath}, Prefixo: {$this->prefix} -->";

        // Remove o prefixo (se existir)
        $prefix = rtrim($this->prefix, '/');
        $uriWithoutPrefix = '';

        if (strlen($prefix) > 0 && strpos($uriPath, $prefix) === 0) {
            $uriWithoutPrefix = substr($uriPath, strlen($prefix));
        } else {
            $uriWithoutPrefix = $uriPath;
        }

        // Normaliza o formato
        $uriWithoutPrefix = '/' . trim($uriWithoutPrefix, '/');

        // Debug temporário
        echo "<!-- URI processada: {$uriWithoutPrefix} -->";

        return $uriWithoutPrefix;
    }

    private  function getRoute()
    {
        $uri = $this->getUri();

        $httpMethod = $this->request->getMethod();


        foreach ($this->routes as $patternRoute => $methods) {
            if (preg_match($patternRoute, $uri)) {

                if (isset($methods[$httpMethod])) {
                    return $methods[$httpMethod];
                }
                throw new Exception("Método não permitido", 405);
            }
        }
        throw new Exception("Pagina não encontrada", 404);
    }
    public function run()
    {
        try {
            $router = $this->getRoute();
            if (!isset($router['controller']) || !$router['controller'] instanceof Closure) {
                throw new Exception("Controller não definido", 500);
            }
            $controller = $router['controller'];
            $reflection = new ReflectionFunction($controller);
            $responseContent = $reflection->invokeArgs([$this->request, $router]);

            return $responseContent;
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            $errorMessage = $e->getMessage() ?: 'Erro interno do servidor';


            $errorController = new ErrorController();
            $errorResponse = $errorController->renderError([
                'message' => $errorMessage,
                'code' => $statusCode
            ]);
            return new Response($statusCode==404?404:500, $statusCode==404?'Pagina não encontrada':'Erro interno do servidor');
        }
    }
}
