<?php

namespace VetApp\Interfaces\Http\Controllers;

use VetApp\Application\Client\ManageClientUseCase;
use VetApp\Application\Pet\ManagePetUseCase;
use VetApp\Core\FlashMessages;

class ClientController
{
    private ManageClientUseCase $clientUseCase;
    private ManagePetUseCase $petUseCase;
    private FlashMessages $flash;

    public function __construct(ManageClientUseCase $clientUseCase, ManagePetUseCase $petUseCase)
    {
        $this->clientUseCase = $clientUseCase;
        $this->petUseCase = $petUseCase;
        $this->flash = new FlashMessages();
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
        $pets = $petsData['data'];

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

        try {
            $id = $this->clientUseCase->createClient(
                $_POST['firstName'],
                $_POST['lastName'],
                $_POST['phone'],
                $_POST['address']
            );

            $this->flash->success('Cliente registrado exitosamente', "/clients/$id");
            header("Location: /clients/$id");
            exit;
        } catch (\Exception $e) {
            $this->flash->error('Error al registrar el cliente: ' . $e->getMessage(), '/clients/create');
            header("Location: /clients/create");
            exit;
        }
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

        try {
            $success = $this->clientUseCase->updateClient(
                $id,
                $_POST['firstName'],
                $_POST['lastName'],
                $_POST['phone'],
                $_POST['address']
            );

            if ($success) {
                $this->flash->success('Cliente actualizado exitosamente', "/clients/$id");
                header("Location: /clients/$id");
            } else {
                $this->flash->error('No se pudo actualizar el cliente', "/clients/$id/edit");
                header("Location: /clients/$id/edit");
            }
            exit;
        } catch (\Exception $e) {
            $this->flash->error('Error al actualizar el cliente: ' . $e->getMessage(), "/clients/$id/edit");
            header("Location: /clients/$id/edit");
            exit;
        }
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        try {
            $success = $this->clientUseCase->deleteClient($id);

            if ($success) {
                $this->flash->success('Cliente eliminado exitosamente', '/clients');
                header("Location: /clients");
            } else {
                $this->flash->error('No se pudo eliminar el cliente', "/clients/$id");
                header("Location: /clients/$id");
            }
            exit;
        } catch (\Exception $e) {
            $this->flash->error('Error al eliminar el cliente: ' . $e->getMessage(), "/clients/$id");
            header("Location: /clients/$id");
            exit;
        }
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
