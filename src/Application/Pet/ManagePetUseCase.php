<?php

namespace VetApp\Application\Pet;

use VetApp\Domain\Entities\Pet;
use VetApp\Domain\Repositories\PetRepositoryInterface;
use VetApp\Domain\Repositories\SpeciesRepositoryInterface;
use VetApp\Domain\Repositories\BreedRepositoryInterface;

class ManagePetUseCase
{
    private PetRepositoryInterface $petRepository;
    private SpeciesRepositoryInterface $speciesRepository;
    private BreedRepositoryInterface $breedRepository;

    public function __construct(
        PetRepositoryInterface $petRepository,
        SpeciesRepositoryInterface $speciesRepository,
        BreedRepositoryInterface $breedRepository
    ) {
        $this->petRepository = $petRepository;
        $this->speciesRepository = $speciesRepository;
        $this->breedRepository = $breedRepository;
    }

    public function getAllPets(int $page = 1, int $perPage = 10): array
    {
        $pets = $this->petRepository->findAll($page, $perPage);
        $total = $this->petRepository->countAll();
        $totalPages = ceil($total / $perPage);

        // Enriquece los datos de mascotas con nombres de especies y razas
        $enrichedPets = $this->enrichPetData($pets);

        return [
            'data' => $enrichedPets,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $totalPages
        ];
    }

    public function getPet(int $id): ?array
    {
        $pet = $this->petRepository->find($id);
        if (!$pet) {
            return null;
        }

        // Retorna la mascota con el nombre de la especia y raza (arreglo en pos 0)
        return $this->enrichPetData([$pet])[0];
    }

    public function createPet(
        string $name,
        int $speciesId,
        ?int $breedId,
        string $gender,
        string $lifeStage,
        float $weight,
        int $clientId
    ): int {
        // Valida que la especie existe
        $species = $this->speciesRepository->find($speciesId);
        if (!$species) {
            throw new \Exception("La especie seleccionada no existe");
        }

        // Valida que la raza pertenece a la especie si se proporciona
        if ($breedId !== null) {
            $breed = $this->breedRepository->find($breedId);
            if (!$breed || $breed->getSpeciesId() !== $speciesId) {
                throw new \Exception("La raza seleccionada no es válida para esta especie");
            }
        }

        $pet = new Pet(
            0, // La BD lo reemplaza
            $name,
            $speciesId,
            $breedId,
            $gender,
            $lifeStage,
            $weight,
            $clientId
        );

        return $this->petRepository->save($pet);
    }

    public function updatePet(
        int $id,
        string $name,
        int $speciesId,
        ?int $breedId,
        string $gender,
        string $lifeStage,
        float $weight,
        int $clientId
    ): bool {
        // Valida que la mascota existe
        $existingPet = $this->petRepository->find($id);
        if (!$existingPet) {
            return false;
        }

        // Valida que la especie existe
        $species = $this->speciesRepository->find($speciesId);
        if (!$species) {
            throw new \Exception("La especie seleccionada no existe");
        }

        // Valida que la raza pertenece a la especie si se proporciona
        if ($breedId !== null) {
            $breed = $this->breedRepository->find($breedId);
            if (!$breed || $breed->getSpeciesId() !== $speciesId) {
                throw new \Exception("La raza seleccionada no es válida para esta especie");
            }
        }

        $pet = new Pet(
            $id,
            $name,
            $speciesId,
            $breedId,
            $gender,
            $lifeStage,
            $weight,
            $clientId
        );

        return $this->petRepository->update($pet);
    }

    public function deletePet(int $id): bool
    {
        return $this->petRepository->delete($id);
    }

    public function searchPets(string $query, int $page = 1, int $perPage = 10): array
    {
        $pets = $this->petRepository->search($query, $page, $perPage);
        $total = $this->petRepository->countSearch($query);
        $totalPages = ceil($total / $perPage);

        // Enriquece los datos de mascotas con nombres de especies y razas
        $enrichedPets = $this->enrichPetData($pets);

        return [
            'data' => $enrichedPets,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $totalPages,
            'query' => $query
        ];
    }

    public function getPetsByClient(int $clientId, int $page = 1, int $perPage = 10): array
    {
        $pets = $this->petRepository->findByClientId($clientId);
        $total = $this->petRepository->countByClientId($clientId);
        $totalPages = ceil($total / $perPage);

        // Enriquece los datos de mascotas con nombres de especies y razas
        $enrichedPets = $this->enrichPetData($pets);

        return [
            'data' => $enrichedPets,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $totalPages,
            'clientId' => $clientId
        ];
    }

    /**
     * Agrega el nombre de la especie y raza de la mascotas
     * 
     * @param array $pets Mascotas a las cuales se le agregaran los campos de especie y raza (name)
     * @return array Devuelve el arreglo de las mascotas con los campos nuevos
     */
    private function enrichPetData(array $pets): array
    {
        $enrichedPets = [];
        foreach ($pets as $pet) {
            $species = $this->speciesRepository->find($pet->getSpeciesId());
            $breed = $pet->getBreedId() ? $this->breedRepository->find($pet->getBreedId()) : null;

            $petData = [
                'id' => $pet->getId(),
                'name' => $pet->getName(),
                'species_id' => $pet->getSpeciesId(),
                'species_name' => $species ? $species->getName() : 'Desconocida',
                'breed_id' => $pet->getBreedId(),
                'breed_name' => $breed ? $breed->getName() : 'No especificada',
                'gender' => $pet->getGender(),
                'life_stage' => $pet->getLifeStage(),
                'weight' => $pet->getWeight(),
                'client_id' => $pet->getClientId(),
                'pet_object' => $pet // Pet original
            ];

            $enrichedPets[] = $petData;
        }

        return $enrichedPets;
    }
}
