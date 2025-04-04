<?php

namespace VetApp\Infrastructure\Persistence;

use VetApp\Domain\Entities\Species;
use VetApp\Domain\Repositories\SpeciesRepositoryInterface;
use PDO;

class SpeciesRepository implements SpeciesRepositoryInterface
{
    public function __construct(private PDO $connection) {}

    public function findAll(): array
    {
        $stmt = $this->connection->query("SELECT * FROM species ORDER BY name");
        return array_map(
            fn($data) => new Species($data['id'], $data['name'], $data['description']),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function findById(int $id): ?Species
    {
        $stmt = $this->connection->prepare("SELECT * FROM species WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Species($data['id'], $data['name'], $data['description']) : null;
    }
}
