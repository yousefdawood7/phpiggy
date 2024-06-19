<?php 

declare(strict_types = 1);

namespace Framework;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, array $controller)  {
        $path = $this->normalize($path);
        $method = strtoupper($method);
        $this->routes[] = [
            'path' => $path,
            'method' => $method,
            'controller' => $controller
        ];
    }

    private function normalize(string $path):string {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $normalizedPath = preg_replace('#[/]{2,}#', '/', $path);
        return $normalizedPath;
    }
}