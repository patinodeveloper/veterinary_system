<?php
require_once __DIR__ . '/../../src/Interfaces/Http/Middleware/AuthMiddleware.php';

use VetApp\Infrastructure\Auth\SessionAuth;
use VetApp\Interfaces\Http\Middleware\AuthMiddleware;

$sessionAuth = new SessionAuth();
$authMiddleware = new AuthMiddleware($sessionAuth);
$authMiddleware->handle();

$user = $sessionAuth->getUser();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Veterinaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-semibold">Veterinaria</span>
                    </div>
                    <div class="flex items-center">
                        <span class="mr-4"><?= htmlspecialchars($user['name']) ?></span>
                        <a href="/logout" class="text-blue-500 hover:text-blue-700">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenido -->
        <div class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard</h1>

                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Bienvenido, <?= htmlspecialchars($user['name']) ?></h2>
                    <p class="text-gray-600">Rol: <?= htmlspecialchars($user['role']) ?></p>

                    <!-- Contenido proximo -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>