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
            // Verifica método HTTP
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            // Convertir ruta a patron regex
            $pattern = str_replace('/', '\/', $route['path']);
            $pattern = preg_replace('/\{[a-z]+\}/', '(\d+)', $pattern);
            $pattern = '/^' . $pattern . '$/';

            // Verificar coincidencia
            if (preg_match($pattern, $requestUri, $matches)) {
                // Extraer parámetros
                array_shift($matches); // Quitar el match completo
                
                // Llamar al handler con parámetros
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }

        // Ruta no encontrada
        http_response_code(404);
        include __DIR__ . '/../../public/views/errors/404.php';
        exit;
    }
}
