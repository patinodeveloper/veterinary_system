<?php

namespace VetApp\Application\Breed;

use VetApp\Domain\Entities\Breed;
use VetApp\Domain\Repositories\BreedRepositoryInterface;

class ManageBreedUseCase
{
    private BreedRepositoryInterface $breedRepository;

    public function __construct(BreedRepositoryInterface $breedRepository)
    {
        $this->breedRepository = $breedRepository;
    }

    public function getAllBreeds(int $page = 1, int $perPage = 10): array
    {
        $breeds = $this->breedRepository->findAll($page, $perPage);
        $total = $this->breedRepository->countAll();
        $totalPages = ceil($total / $perPage);

        return [
            'data' => $breeds,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $totalPages
        ];
    }

    public function getBreed(int $id): ?Breed
    {
        return $this->breedRepository->find($id);
    }

    public function createBreed(string $name, int $speciesId): int
    {
        $breed = new Breed(
            0, // Lo reemplaza la BD
            $name,
            $speciesId
        );

        return $this->breedRepository->save($breed);
    }

    public function updateBreed(int $id, string $name, int $speciesId): bool
    {
        $breed = $this->breedRepository->find($id);
        if (!$breed) {
            return false;
        }

        $breed = new Breed(
            $id,
            $name,
            $speciesId
        );

        return $this->breedRepository->update($breed);
    }

    public function deleteBreed(int $id): bool
    {
        return $this->breedRepository->delete($id);
    }

    public function searchBreeds(string $query): array
    {
        return $this->breedRepository->search($query);
    }

    public function getBreedsBySpecies(int $speciesId): array
    {
        return $this->breedRepository->findBySpeciesId($speciesId);
    }
}
