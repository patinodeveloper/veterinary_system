<?php

namespace VetApp\Interfaces\Http\Controllers;

use VetApp\Application\Species\ManageSpeciesUseCase;

class SpeciesController
{
    private ManageSpeciesUseCase $speciesUseCase;

    public function __construct(ManageSpeciesUseCase $speciesUseCase)
    {
        $this->speciesUseCase = $speciesUseCase;
    }

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;

        $result = $this->speciesUseCase->getAllSpecies($page, $perPage);

        $species = $result['data'];
        $totalPages = $result['totalPages'];
        $currentPage = $result['page'];

        include __DIR__ . '/../../../../public/views/species/index.php';
    }

    public function show(int $id)
    {
        $species = $this->speciesUseCase->getSpecies($id);
        if (!$species) {
            header("HTTP/1.0 404 Not Found");
            echo "Especie no encontrada";
            return;
        }
        include __DIR__ . '/../../../../public/views/species/show.php';
    }

    public function create()
    {
        include __DIR__ . '/../../../../public/views/species/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $id = $this->speciesUseCase->createSpecies(
            $_POST['name'],
            $_POST['description'] ?? null
        );

        header("Location: /species/$id");
        exit;
    }

    public function edit(int $id)
    {
        $species = $this->speciesUseCase->getSpecies($id);
        if (!$species) {
            header("HTTP/1.0 404 Not Found");
            echo "Especie no encontrada";
            return;
        }
        include __DIR__ . '/../../../../public/views/species/edit.php';
    }

    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $success = $this->speciesUseCase->updateSpecies(
            $id,
            $_POST['name'],
            $_POST['description'] ?? null
        );

        if ($success) {
            header("Location: /species/$id");
        } else {
            header("Location: /species/$id/edit?error=1");
        }
        exit;
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $success = $this->speciesUseCase->deleteSpecies($id);

        if ($success) {
            header("Location: /species");
        } else {
            header("Location: /species/$id?error=1");
        }
        exit;
    }

    public function search()
    {
        $query = $_GET['q'] ?? '';
        $result = $this->speciesUseCase->searchSpecies($query);

        $species = $result;
        $searchQuery = $query;

        include __DIR__ . '/../../../../public/views/species/search.php';
    }
}
