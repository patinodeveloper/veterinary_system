<?php
require_once __DIR__ . '/../vendor/autoload.php';

use VetApp\Core\Router;
use VetApp\Interfaces\Http\Controllers\AuthController;
use VetApp\Application\Auth\LoginUseCase;
use VetApp\Application\Breed\ManageBreedUseCase;
use VetApp\Application\Client\ManageClientUseCase;
use VetApp\Application\Pet\ManagePetUseCase;
use VetApp\Application\Species\ManageSpeciesUseCase;
use VetApp\Core\FlashMessages;
use VetApp\Domain\Services\AuthService;
use VetApp\Infrastructure\Persistence\UserRepository;
use VetApp\Infrastructure\Auth\SessionAuth;
use VetApp\Infrastructure\Persistence\BreedRepository;
use VetApp\Infrastructure\Persistence\ClientRepository;
use VetApp\Infrastructure\Persistence\PetRepository;
use VetApp\Infrastructure\Persistence\SpeciesRepository;
use VetApp\Interfaces\Http\Controllers\BreedController;
use VetApp\Interfaces\Http\Controllers\ClientController;
use VetApp\Interfaces\Http\Controllers\PetController;
use VetApp\Interfaces\Http\Controllers\SpeciesController;


// Iniciar sesion para los mensajes flash si no esta iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Instancia de FlashMessages para mensajes flash
$flashMessages = new FlashMessages();

// Instancias de las clases necesarias
$userRepository = new UserRepository();
$authService = new AuthService($userRepository);
$sessionAuth = new SessionAuth();
$loginUseCase = new LoginUseCase($authService, $sessionAuth);
$authController = new AuthController($loginUseCase, $sessionAuth);

// Configuración de dependencias para Especies
$speciesRepository = new SpeciesRepository();
$speciesUseCase = new ManageSpeciesUseCase($speciesRepository);
$speciesController = new SpeciesController($speciesUseCase);

// Configuración de dependencias para Razas
$breedRepository = new BreedRepository();
$breedUseCase = new ManageBreedUseCase($breedRepository);
$breedController = new BreedController($breedUseCase, $speciesUseCase);

// Configuración de dependencias para Mascotas
$petRepository = new PetRepository();
$petUseCase = new ManagePetUseCase($petRepository, $speciesRepository, $breedRepository);

// Configuración de dependencias para clientes
$clientRepository = new ClientRepository();
$clientUseCase = new ManageClientUseCase($clientRepository);
$clientController = new ClientController($clientUseCase, $petUseCase);

// Controlador de Mascotas
$petController = new PetController($petUseCase, $speciesUseCase, $breedUseCase, $clientUseCase);

// Enrutador
$router = new Router();

// Rutas Auth
$router->add('GET', '/login', [$authController, 'showLoginForm']);
$router->add('POST', '/login', [$authController, 'login']);
$router->add('GET', '/logout', [$authController, 'logout']);

// Dashboard
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

// Endpoint para obtener las razas por especie (ID)
$router->add('GET', '/api/species/{id}/breeds', function ($id) use ($breedController) {
    $breedController->bySpecies((int)$id);
});

$router->add('GET', '/', function () {
    header('Location: /login');
    exit();
});

// Manejar la solicitudes
$router->dispatch();
