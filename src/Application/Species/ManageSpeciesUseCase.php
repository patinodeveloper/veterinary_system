<?php

namespace VetApp\Application\Species;

use VetApp\Domain\Entities\Species;
use VetApp\Domain\Repositories\SpeciesRepositoryInterface;

class ManageSpeciesUseCase
{
    private SpeciesRepositoryInterface $speciesRepository;

    public function __construct(SpeciesRepositoryInterface $speciesRepository)
    {
        $this->speciesRepository = $speciesRepository;
    }

    public function getAllSpecies(int $page = 1, int $perPage = 10): array
    {
        $species = $this->speciesRepository->findAll($page, $perPage);
        $total = $this->speciesRepository->countAll();
        $totalPages = ceil($total / $perPage);

        return [
            'data' => $species,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $totalPages
        ];
    }

    public function getSpecies(int $id): ?Species
    {
        return $this->speciesRepository->find($id);
    }

    public function createSpecies(string $name, ?string $description = null): int
    {
        $species = new Species(
            0,
            $name,
            $description
        );

        return $this->speciesRepository->save($species);
    }

    public function updateSpecies(int $id, string $name, ?string $description = null): bool
    {
        $species = $this->speciesRepository->find($id);
        if (!$species) {
            return false;
        }

        $species = new Species(
            $id,
            $name,
            $description
        );

        return $this->speciesRepository->update($species);
    }

    public function deleteSpecies(int $id): bool
    {
        return $this->speciesRepository->delete($id);
    }

    public function searchSpecies(string $query): array
    {
        return $this->speciesRepository->search($query);
    }
}
