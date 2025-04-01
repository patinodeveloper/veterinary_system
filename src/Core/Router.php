<?php

namespace VetApp\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                call_user_func($route['handler']);
                return;
            }
        }

        // Ruta no encontrada
        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
    }
}
