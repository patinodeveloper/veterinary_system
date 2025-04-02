<?php
require_once __DIR__ . '/../vendor/autoload.php';

use VetApp\Core\Router;
use VetApp\Interfaces\Http\Controllers\AuthController;
use VetApp\Application\Auth\LoginUseCase;
use VetApp\Application\Client\ManageClientUseCase;
use VetApp\Domain\Services\AuthService;
use VetApp\Infrastructure\Persistence\UserRepository;
use VetApp\Infrastructure\Auth\SessionAuth;
use VetApp\Infrastructure\Persistence\ClientRepository;
use VetApp\Interfaces\Http\Controllers\ClientController;

// Instancias de las clases necesarias
$userRepository = new UserRepository();
$authService = new AuthService($userRepository);
$sessionAuth = new SessionAuth();
$loginUseCase = new LoginUseCase($authService, $sessionAuth);
$authController = new AuthController($loginUseCase, $sessionAuth);

// Configuración de dependencias para clientes
$clientRepository = new ClientRepository();
$clientUseCase = new ManageClientUseCase($clientRepository);
$clientController = new ClientController($clientUseCase);

// Enrutador
$router = new Router();

// Rutas
$router->add('GET', '/login', [$authController, 'showLoginForm']);
$router->add('POST', '/login', [$authController, 'login']);
$router->add('GET', '/logout', [$authController, 'logout']);

$router->add('GET', '/dashboard', function () {
    include __DIR__ . '/views/dashboard.php';
});

// Rutas para clientes
$router->add('GET', '/clients', [$clientController, 'index']);
$router->add('GET', '/clients/create', [$clientController, 'create']);
$router->add('POST', '/clients', [$clientController, 'store']);
$router->add('GET', '/clients/search', [$clientController, 'search']);
$router->add('GET', '/clients/{id}', [$clientController, 'show']);
$router->add('GET', '/clients/{id}/edit', [$clientController, 'edit']);
$router->add('POST', '/clients/{id}', [$clientController, 'update']);
$router->add('POST', '/clients/{id}/delete', [$clientController, 'delete']);

$router->add('GET', '/', function () {
    header('Location: /login');
    exit();
});

// Manejar la solicitudes
$router->dispatch();
