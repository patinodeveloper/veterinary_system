<?php

namespace VetApp\Interfaces\Http\Controllers;

use VetApp\Application\Pet\ManagePetUseCase;
use VetApp\Infrastructure\Persistence\ClientRepository;

class PetController
{
    private ManagePetUseCase $petUseCase;

    public function __construct(ManagePetUseCase $petUseCase)
    {
        $this->petUseCase = $petUseCase;
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
        // Obtener el repositorio de clientes
        $clientRepository = new ClientRepository();

        // Obtener todos los clientes (puedes agregar paginación si hay muchos)
        $clients = $clientRepository->findAll(1, 1000)['data']; // Ajusta según tu implementación

        // Pasar los clientes a la vista
        $clientId = $_GET['client_id'] ?? null;
        include __DIR__ . '/../../../../public/views/pets/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $id = $this->petUseCase->createPet(
            $_POST['name'],
            $_POST['species'],
            $_POST['breed'],
            $_POST['gender'],
            $_POST['life_stage'],
            $_POST['weight'],
            $_POST['client_id']
        );

        header("Location: /pets/$id");
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
        include __DIR__ . '/../../../../public/views/pets/edit.php';
    }

    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $success = $this->petUseCase->updatePet(
            $id,
            $_POST['name'],
            $_POST['species'],
            $_POST['breed'],
            $_POST['gender'],
            $_POST['life_stage'],
            $_POST['weight'],
            $_POST['client_id']
        );

        if ($success) {
            header("Location: /pets/$id");
        } else {
            header("Location: /pets/$id/edit?error=1");
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

    // public function byClient(int $clientId)
    // {
    //     $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    //     $perPage = 10;

    //     $result = $this->petUseCase->getPetsByClient($clientId, $page, $perPage);

    //     $pets = $result['data'];
    //     $totalPages = $result['totalPages'];
    //     $currentPage = $result['page'];
    //     $clientId = $result['clientId'];

    //     include __DIR__ . '/../../../../public/views/pets/by_client.php';
    // }
}
