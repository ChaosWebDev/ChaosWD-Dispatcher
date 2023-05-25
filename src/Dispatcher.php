<?php

namespace Order;

class Dispatcher
{
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    // ! REQUEST_METHOD METHODS ! //

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    // ! FUNCTIONALITY METHODS ! //

    public static function loadRoutes($file)
    {
        $router = new static;
        require $file;
        return $router;
    }

    protected function skipRouting($uri)
    {
        $skipFiles = [
            '/favicon.ico',
            '/manifest.json',
            '/images/favicon.ico',
            '/images/manifest.json'
        ];

        return in_array($uri, $skipFiles);
    }

    public function dispatcher($uri, $requestType)
    {
        if ($this->skipRouting($uri)) {
            die("FAIL");
            return;
        }

        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        throw new \Exception('No route defined for this URI.');
    }

    protected function callAction($controller, $action)
    {
        $controller = "ChaosWD\\ChaosFramework\\{$controller}";

        if (!class_exists($controller)) {
            throw new \Exception(exit("{$controller} does not exist."));
        }

        $controller = new $controller;
        if (!method_exists($controller, $action)) {
            throw new \Exception(exit("{$controller} does not respond to the {$action} action."));
        }

        return $controller->$action();
    }
}
