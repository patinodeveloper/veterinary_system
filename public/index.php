<?php
require_once __DIR__ . '/../vendor/autoload.php';

use VetApp\Core\Router;
use VetApp\Interfaces\Http\Controllers\AuthController;
use VetApp\Application\Auth\LoginUseCase;
use VetApp\Application\Client\ManageClientUseCase;
use VetApp\Application\Pet\ManagePetUseCase;
use VetApp\Domain\Services\AuthService;
use VetApp\Infrastructure\Persistence\UserRepository;
use VetApp\Infrastructure\Auth\SessionAuth;
use VetApp\Infrastructure\Persistence\ClientRepository;
use VetApp\Infrastructure\Persistence\PetRepository;
use VetApp\Interfaces\Http\Controllers\ClientController;
use VetApp\Interfaces\Http\Controllers\PetController;

// Instancias de las clases necesarias
$userRepository = new UserRepository();
$authService = new AuthService($userRepository);
$sessionAuth = new SessionAuth();
$loginUseCase = new LoginUseCase($authService, $sessionAuth);
$authController = new AuthController($loginUseCase, $sessionAuth);

// Configuración de dependencias para mascotas
$petRepository = new PetRepository();
$petUseCase = new ManagePetUseCase($petRepository);
$petController = new PetController($petUseCase);

// Configuración de dependencias para clientes
$clientRepository = new ClientRepository();
$clientUseCase = new ManageClientUseCase($clientRepository);
$clientController = new ClientController($clientUseCase, $petUseCase);

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

// Rutas para mascotas
$router->add('GET', '/pets', [$petController, 'index']);
$router->add('GET', '/pets/create', [$petController, 'create']);
$router->add('POST', '/pets', [$petController, 'store']);
$router->add('GET', '/pets/search', [$petController, 'search']);
$router->add('GET', '/pets/{id}', [$petController, 'show']);
$router->add('GET', '/pets/{id}/edit', [$petController, 'edit']);
$router->add('POST', '/pets/{id}', [$petController, 'update']);
$router->add('POST', '/pets/{id}/delete', [$petController, 'delete']);
// $router->add('GET', '/clients/{clientId}/pets', [$petController, 'byClient']);

$router->add('GET', '/', function () {
    header('Location: /login');
    exit();
});

// Manejar la solicitudes
$router->dispatch();
