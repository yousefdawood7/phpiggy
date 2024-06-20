<?php

declare(strict_types=1);

namespace Framework;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, array $controller) {
        $path = $this->normalize($path);
        $method = strtoupper($method);
        $this->routes[] = [
            'path' => $path,
            'method' => $method,
            'controller' => $controller
        ];
    }

    public function dispatch(string $path, string $method) {
        $path =  $this->normalize($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (preg_match("#^{$route['path']}$#", $path) && $route['method'] === $method) {
                [$class, $function] = $route['controller'];
                $classInstance = new $class;
                $classInstance->{$function}();
            }
        }
    }

    private function normalize(string $path): string {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);
        return $path;
    }
}
