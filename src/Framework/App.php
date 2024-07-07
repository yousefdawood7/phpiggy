<?php

declare(strict_types=1);

namespace Framework;

use App\Config\Paths;

class App {
    private Router $router;
    private Container $container;

    function __construct(string $containerDefinitionPath = NULL) {
        $this->router = new Router;
        $this->container = new Container;

        if ($containerDefinitionPath) {
            $definitions = include $containerDefinitionPath;
            $this->container->addDefinition($definitions);
        }
    }

    public function run() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $this->router->dispatch($path, $method, $this->container);
    }

    public function get(string $path, array $controller) {
        $this->router->add('GET', $path, $controller);
    }

    public function post(string $path, array $controller) {
        $this->router->add('POST', $path, $controller);
    }

    public function addMiddleware(string $middleware) {
        $this->router->addMiddleware($middleware);
    }
}
