<?php

declare(strict_types=1);

namespace Framework;

class Router {
    private array $routes = [];
    private array $middlewares = [];

    public function add(string $method, string $path, array $controller) {
        $path = $this->normalize($path);
        $method = strtoupper($method);
        $this->routes[] = [
            'path' => $path,
            'method' => $method,
            'controller' => $controller
        ];
    }

    public function dispatch(string $path, string $method, Container $container = NULL) {
        $path = $this->normalize($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (preg_match("#^{$route['path']}$#", $path) && $route['method'] === $method) {
                [$class, $function] = $route['controller'];
                $classInstance = $container ? $container->resolve($class) : new $class;
                $action = fn () => $classInstance->{$function}();
                foreach ($this->middlewares as $middleware) {
                    $middlewareInstance = $container ?
                        $container->resolve($middleware)
                        : new $middleware;
                    $action = fn () => $middlewareInstance->process($action);
                }
                $action();
                return;
            }
        }
    }

    private function normalize(string $path): string {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);
        return $path;
    }

    public function addMiddleware(string $middleware) {
        $this->middlewares[] = $middleware;
    }
}
