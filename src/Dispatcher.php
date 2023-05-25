<?php

namespace Order;

class Dispatcher
{
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    // ! REQUEST_METHOD METHODS ! //

    public function get($uri, $namespace, $controllerMethod)
    {
        $this->routes['GET'][$uri] = [
            'namespace' => $namespace,
            'controllerMethod' => $controllerMethod,
        ];
    }

    public function post($uri, $namespace, $controllerMethod)
    {
        $this->routes['GET'][$uri] = [
            'namespace' => $namespace,
            'controllerMethod' => $controllerMethod,
        ];
    }

    // ! FUNCTIONALITY METHODS ! //

    public static function loadRoutes($file)
    {
        $router = new static;
        require $file;
        return $router;
    }

    public function dispatcher($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            $route = $this->routes[$requestType][$uri];
            $namespace = $route['namespace'];
            $controllerMethod = $route['controllerMethod'];
            [$controller, $method] = explode('@', $controllerMethod);

            return $this->callAction($namespace, $controller, $method);
        }
        return;
        //throw new \Exception("No route defined for URI {$uri}");
    }

    protected function callAction($namespace, $controller, $action)
    {
        $controllerNamespace = "{$namespace}\\{$controller}";

        if (!class_exists($controllerNamespace)) {
            throw new \Exception(exit("Class: {$controllerNamespace} does not exist."));
        }

        $controllerInstance = new $controllerNamespace;

        if (!method_exists($controllerInstance, $action)) {
            throw new \Exception(exit("{$controllerNamespace} does not respond to the {$action} action."));
        }

        return $controllerInstance->$action();
    }
}
