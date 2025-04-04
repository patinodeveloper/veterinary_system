<?php

namespace VetApp\Application\Pet;

use VetApp\Domain\Entities\Pet;
use VetApp\Domain\Repositories\PetRepositoryInterface;

class ManagePetUseCase
{
    private PetRepositoryInterface $repository;

    public function __construct(PetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPet(int $id): ?Pet
    {
        return $this->repository->find($id);
    }

    public function getAllPets(int $page = 1, int $perPage = 10): array
    {
        return [
            'data' => $this->repository->findAll($page, $perPage),
            'total' => $this->repository->countAll(),
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($this->repository->countAll() / $perPage)
        ];
    }

    public function createPet(
        string $name,
        string $species,
        string $breed,
        string $gender,
        string $lifeStage,
        string $weight,
        string $clientId
    ): int {
        $pet = new Pet(0, $name, $species, $breed, $gender, $lifeStage, $weight, $clientId);
        return $this->repository->save($pet);
    }

    public function updatePet(
        int $id,
        string $name,
        string $species,
        string $breed,
        string $gender,
        string $lifeStage,
        string $weight,
        string $clientId
    ): bool {
        $pet = new Pet($id, $name, $species, $breed, $gender, $lifeStage, $weight, $clientId);
        return $this->repository->update($pet);
    }

    public function deletePet(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function searchPets(string $query, int $page = 1, int $perPage = 10): array
    {
        return [
            'data' => $this->repository->search($query, $page, $perPage),
            'total' => $this->repository->countSearch($query),
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($this->repository->countSearch($query) / $perPage),
            'query' => $query
        ];
    }

    public function getPetsByClient(int $clientId, int $page = 1, int $perPage = 10): array
    {
        return [
            'pets' => $this->repository->findByClientId($clientId),
            'total' => $this->repository->countByClientId($clientId),
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => 1, // No usamos paginación aquí
            'clientId' => $clientId
        ];
    }
}
