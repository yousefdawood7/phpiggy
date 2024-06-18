<?php 

declare(strict_types = 1);

namespace Framework;

class Router {
    private array $routes = [];

    public function add(string $method, string $path) {
        $path = $this->normalize($path);
        $this->routes[] = [
            "path" => $path,
            "method" => strtoupper($method)
        ];
    }

    private function normalize(string $path): string {
        $path = trim($path, "/");
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);
        return $path;
    }
}
