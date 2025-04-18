<?php

namespace VetApp\Interfaces\Http\Controllers;

use VetApp\Application\Breed\ManageBreedUseCase;
use VetApp\Application\Species\ManageSpeciesUseCase;

class BreedController
{
    private ManageBreedUseCase $breedUseCase;
    private ManageSpeciesUseCase $speciesUseCase;

    public function __construct(ManageBreedUseCase $breedUseCase, ManageSpeciesUseCase $speciesUseCase)
    {
        $this->breedUseCase = $breedUseCase;
        $this->speciesUseCase = $speciesUseCase;
    }

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;

        $result = $this->breedUseCase->getAllBreeds($page, $perPage);

        $breeds = $result['data'];
        $totalPages = $result['totalPages'];
        $currentPage = $result['page'];

        // Obtiene la info de especies para cada raza
        $speciesData = [];
        foreach ($breeds as $breed) {
            $species = $this->speciesUseCase->getSpecies($breed->getSpeciesId());
            $speciesData[$breed->getId()] = $species ? $species->getName() : 'Desconocida';
        }

        include __DIR__ . '/../../../../public/views/breeds/index.php';
    }

    public function show(int $id)
    {
        $breed = $this->breedUseCase->getBreed($id);
        if (!$breed) {
            header("HTTP/1.0 404 Not Found");
            echo "Raza no encontrada";
            return;
        }

        $species = $this->speciesUseCase->getSpecies($breed->getSpeciesId());
        $speciesName = $species ? $species->getName() : 'Desconocida';

        include __DIR__ . '/../../../../public/views/breeds/show.php';
    }

    public function create()
    {
        // Obtiene todas las especies para el formulario de selección
        $speciesResult = $this->speciesUseCase->getAllSpecies(1, 1000);
        $speciesList = $speciesResult['data'];

        // Obtiene species_id desde la URL
        $selectedSpeciesId = $_GET['species_id'] ?? null;

        include __DIR__ . '/../../../../public/views/breeds/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $id = $this->breedUseCase->createBreed(
            $_POST['name'],
            (int)$_POST['species_id']
        );

        header("Location: /breeds/$id");
        exit;
    }

    public function edit(int $id)
    {
        $breed = $this->breedUseCase->getBreed($id);
        if (!$breed) {
            header("HTTP/1.0 404 Not Found");
            echo "Raza no encontrada";
            return;
        }

        // Obtiene todas las especies para el formulario de selección
        $speciesResult = $this->speciesUseCase->getAllSpecies(1, 1000);
        $speciesList = $speciesResult['data'];

        include __DIR__ . '/../../../../public/views/breeds/edit.php';
    }

    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $success = $this->breedUseCase->updateBreed(
            $id,
            $_POST['name'],
            (int)$_POST['species_id']
        );

        if ($success) {
            header("Location: /breeds/$id");
        } else {
            header("Location: /breeds/$id/edit?error=1");
        }
        exit;
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.0 405 Method Not Allowed");
            exit;
        }

        $success = $this->breedUseCase->deleteBreed($id);

        if ($success) {
            header("Location: /breeds");
        } else {
            header("Location: /breeds/$id?error=1");
        }
        exit;
    }

    // Endpoint para obtener las razas por especies
    public function bySpecies(int $speciesId)
    {
        $breeds = $this->breedUseCase->getBreedsBySpecies($speciesId);

        $breedsArray = array_map(function ($breed) {
            return [
                'id' => $breed->getId(),
                'name' => $breed->getName()
            ];
        }, $breeds);

        header('Content-Type: application/json');
        echo json_encode($breedsArray);
        exit;

        $species = $this->speciesUseCase->getSpecies($speciesId);
        if (!$species) {
            header("HTTP/1.0 404 Not Found");
            echo "Especie no encontrada";
            return;
        }

        include __DIR__ . '/../../../../public/views/breeds/by_species.php';
    }
}
