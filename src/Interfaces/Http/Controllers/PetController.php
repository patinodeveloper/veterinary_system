<?php

namespace VetApp\Interfaces\Http\Controllers;

use VetApp\Application\Pet\ManagePetUseCase;
use VetApp\Infrastructure\Persistence\ClientRepository;
use VetApp\Application\Species\ManageSpeciesUseCase;
use VetApp\Application\Breed\ManageBreedUseCase;
use VetApp\Application\Client\ManageClientUseCase;

class PetController
{
    private ManagePetUseCase $petUseCase;
    private ManageSpeciesUseCase $speciesUseCase;
    private ManageBreedUseCase $breedUseCase;
    private ManageClientUseCase $clientUseCase;

    public function __construct(
        ManagePetUseCase $petUseCase,
        ManageSpeciesUseCase $speciesUseCase,
        ManageBreedUseCase $breedUseCase,
        ManageClientUseCase $clientUseCase
    ) {
        $this->petUseCase = $petUseCase;
        $this->speciesUseCase = $speciesUseCase;
        $this->breedUseCase = $breedUseCase;
        $this->clientUseCase = $clientUseCase;
    }

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;

        $result = $this->petUseCase->getAllPets($page, $perPage);

        $pets = $result['data'];
        $totalPages = $result['totalPages'];
        $currentPage = $result['page'];

        include __DIR__ . '/../../../../public/views/pets/index.php';
    }

    public function show(int $id)
    {
        $pet = $this->petUseCase->getPet($id);
        if (!$pet) {
            header("HTTP/1.0 404 Not Found");
            echo "Mascota no encontrada";
            return;
        }
        include __DIR__ . '/../../../../public/views/pets/show.php';
    }

    public function create()
    {
        // Obtiene el repositorio de clientes
        $clientRepository = new ClientRepository();

        // Obtiene todos los clientes 
        $clients = $clientRepository->findAll(1, 1000)['data'];

        // Obtiene todas las especies
        $speciesResult = $this->speciesUseCase->getAllSpecies(1, 1000);
        $speciesList = $speciesResult['data'];

        // Valores predeterminados o preseleccionados
        $clientId = $_GET['client_id'] ?? null;
        $speciesId = $_GET['species_id'] ?? null;

        $client = null;
        if ($clientId) {
            $client = $this->clientUseCase->getClient($clientId);
        }

        // Si hay una especie seleccionada, obtener sus razas
        $breedsList = [];
        if ($speciesId) {
            $breedsList = $this->breedUseCase->getBreedsBySpecies((int)$speciesId);
        }

        include __DIR__ . '/../../../../public/views/pets/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        try {
            $breedId = !empty($_POST['breed_id']) ? (int)$_POST['breed_id'] : null;

            $id = $this->petUseCase->createPet(
                $_POST['name'],
                (int)$_POST['species_id'],
                $breedId,
                $_POST['gender'],
                $_POST['life_stage'],
                (float)$_POST['weight'],
                (int)$_POST['client_id']
            );

            header("Location: /pets/$id");
        } catch (\Exception $e) {
            // Redirigir de vuelta al formulario con un mensaje de error
            header("Location: /pets/create?error=" . urlencode($e->getMessage()));
        }
        exit;
    }

    public function edit(int $id)
    {
        $pet = $this->petUseCase->getPet($id);
        if (!$pet) {
            header("HTTP/1.0 404 Not Found");
            echo "Mascota no encontrada";
            return;
        }

        // Obtiene el repositorio de clientes
        $clientRepository = new ClientRepository();

        // Obtiene el cliente de la mascota 
        $client = $clientRepository->findByPetId($id);

        // Obtiene todas las especies
        $speciesResult = $this->speciesUseCase->getAllSpecies(1, 1000);
        $speciesList = $speciesResult['data'];

        // Obtener razas para la especie seleccionada
        $breedsList = [];
        if ($pet['species_id']) {
            $breedsList = $this->breedUseCase->getBreedsBySpecies($pet['species_id']);
        }

        include __DIR__ . '/../../../../public/views/pets/edit.php';
    }

    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        try {
            $breedId = !empty($_POST['breed_id']) ? (int)$_POST['breed_id'] : null;

            $success = $this->petUseCase->updatePet(
                $id,
                $_POST['name'],
                (int)$_POST['species_id'],
                $breedId,
                $_POST['gender'],
                $_POST['life_stage'],
                (float)$_POST['weight'],
                (int)$_POST['client_id']
            );

            if ($success) {
                header("Location: /pets/$id");
            } else {
                header("Location: /pets/$id/edit?error=1");
            }
        } catch (\Exception $e) {
            // Redirigir de vuelta al formulario con un mensaje de error
            header("Location: /pets/$id/edit?error=" . urlencode($e->getMessage()));
        }
        exit;
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $success = $this->petUseCase->deletePet($id);

        if ($success) {
            header("Location: /pets");
        } else {
            header("Location: /pets/$id?error=1");
        }
        exit;
    }

    public function search()
    {
        $query = $_GET['q'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;

        $result = $this->petUseCase->searchPets($query, $page, $perPage);

        $pets = $result['data'];
        $totalPages = $result['totalPages'];
        $currentPage = $result['page'];
        $searchQuery = $result['query'];

        include __DIR__ . '/../../../../public/views/pets/index.php';
    }

    public function byClient(int $clientId)
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;

        $result = $this->petUseCase->getPetsByClient($clientId, $page, $perPage);

        $pets = $result['data'];
        $totalPages = $result['totalPages'];
        $currentPage = $result['page'];
        $clientId = $result['clientId'];

        include __DIR__ . '/../../../../public/views/pets/by_client.php';
    }

    public function getBreedsBySpecies(int $speciesId)
    {
        $breeds = $this->breedUseCase->getBreedsBySpecies($speciesId);

        // Esta función se utilizará para AJAX
        header('Content-Type: application/json');
        echo json_encode($breeds);
        exit;
    }
}
