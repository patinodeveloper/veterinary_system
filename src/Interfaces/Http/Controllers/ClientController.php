<?php

namespace VetApp\Interfaces\Http\Controllers;

use VetApp\Application\Client\ManageClientUseCase;
use VetApp\Application\Pet\ManagePetUseCase;

class ClientController
{
    private ManageClientUseCase $clientUseCase;
    private ManagePetUseCase $petUseCase;

    public function __construct(ManageClientUseCase $clientUseCase, ManagePetUseCase $petUseCase)
    {
        $this->clientUseCase = $clientUseCase;
        $this->petUseCase = $petUseCase;
    }

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;

        $result = $this->clientUseCase->getAllClients($page, $perPage);

        $clients = $result['data'];
        $totalPages = $result['totalPages'];
        $currentPage = $result['page'];

        include __DIR__ . '/../../../../public/views/clients/index.php';
    }

    public function show(int $id)
    {
        $client = $this->clientUseCase->getClient($id);
        if (!$client) {
            header("HTTP/1.0 404 Not Found");
            echo "Cliente no encontrado";
            return;
        }

        // Obtener las mascotas del cliente
        $petsData = $this->petUseCase->getPetsByClient($client->getId());
        $pets = $petsData['pets'];
        
        include __DIR__ . '/../../../../public/views/clients/show.php';
    }

    public function create()
    {
        include __DIR__ . '/../../../../public/views/clients/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $id = $this->clientUseCase->createClient(
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['phone'],
            $_POST['address']
        );

        header("Location: /clients/$id");
        exit;
    }

    public function edit(int $id)
    {
        $client = $this->clientUseCase->getClient($id);
        if (!$client) {
            header("HTTP/1.0 404 Not Found");
            echo "Cliente no encontrado";
            return;
        }
        include __DIR__ . '/../../../../public/views/clients/edit.php';
    }

    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $success = $this->clientUseCase->updateClient(
            $id,
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['phone'],
            $_POST['address']
        );

        if ($success) {
            header("Location: /clients/$id");
        } else {
            header("Location: /clients/$id/edit?error=1");
        }
        exit;
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $success = $this->clientUseCase->deleteClient($id);

        if ($success) {
            header("Location: /clients");
        } else {
            header("Location: /clients/$id?error=1");
        }
        exit;
    }

    public function search()
    {
        $query = $_GET['q'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;

        $result = $this->clientUseCase->searchClients($query, $page, $perPage);

        $clients = $result['data'];
        $totalPages = $result['totalPages'];
        $currentPage = $result['page'];
        $searchQuery = $result['query'];

        include __DIR__ . '/../../../../public/views/clients/index.php';
    }
}
