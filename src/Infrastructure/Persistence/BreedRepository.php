<?php

namespace VetApp\Infrastructure\Persistence;

use VetApp\Domain\Entities\Breed;
use VetApp\Domain\Repositories\BreedRepositoryInterface;
use PDO;

class BreedRepository implements BreedRepositoryInterface
{
    public function __construct(private PDO $connection) {}

    public function findBySpecies(int $species_id): array
    {
        $stmt = $this->connection->prepare("
            SELECT * FROM breeds 
            WHERE species_id = :species_id 
            ORDER BY name
        ");
        $stmt->execute([':species_id' => $species_id]);

        return array_map(
            fn($data) => new Breed(
                $data['id'],
                $data['name'],
                $data['species_id'],
                (bool)$data['is_default']
            ),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function findById(int $id): ?Breed
    {
        $stmt = $this->connection->prepare("SELECT * FROM breeds WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Breed(
            $data['id'],
            $data['name'],
            $data['species_id'],
            (bool)$data['is_default']
        ) : null;
    }
}
