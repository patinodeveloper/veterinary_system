<?php
require_once __DIR__ . '/../vendor/autoload.php';

use VetApp\Core\Router;
use VetApp\Interfaces\Http\Controllers\AuthController;
use VetApp\Application\Auth\LoginUseCase;
use VetApp\Domain\Services\AuthService;
use VetApp\Infrastructure\Persistence\UserRepository;
use VetApp\Infrastructure\Auth\SessionAuth;

// Instancias de las clases necesarias
$userRepository = new UserRepository();
$authService = new AuthService($userRepository);
$sessionAuth = new SessionAuth();
$loginUseCase = new LoginUseCase($authService, $sessionAuth);
$authController = new AuthController($loginUseCase, $sessionAuth);

// Enrutador
$router = new Router();

// Rutas
$router->add('GET', '/login', [$authController, 'showLoginForm']);
$router->add('POST', '/login', [$authController, 'login']);
$router->add('GET', '/logout', [$authController, 'logout']);

$router->add('GET', '/dashboard', function () {
    include __DIR__ . '/views/dashboard.php';
});

$router->add('GET', '/', function () {
    header('Location: /login');
    exit();
});

// Manejar la solicitudes
$router->dispatch();
