<?php

namespace VetApp\Infrastructure\Persistence;

use VetApp\Domain\Entities\Species;
use VetApp\Domain\Repositories\SpeciesRepositoryInterface;
use Config\Database;
use PDO;

class SpeciesRepository implements SpeciesRepositoryInterface
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function find(int $id): ?Species
    {
        $stmt = $this->connection->prepare("SELECT * FROM species WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Species(
            $data['id'],
            $data['name'],
            $data['description'] ?? null
        ) : null;
    }

    public function findAll(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->connection->prepare(
            "SELECT * FROM species
             ORDER BY name
             LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $speciesList = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $species = new Species(
                $data['id'],
                $data['name'],
                $data['description'] ?? null
            );
            $speciesList[] = $species;
        }

        return $speciesList;
    }

    public function countAll(): int
    {
        $stmt = $this->connection->query("SELECT COUNT(*) as total FROM species");
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function save(Species $species): int
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO species (name, description) 
             VALUES (:name, :description)"
        );

        $stmt->execute([
            ':name' => $species->getName(),
            ':description' => $species->getDescription()
        ]);

        return $this->connection->lastInsertId();
    }

    public function update(Species $species): bool
    {
        $stmt = $this->connection->prepare(
            "UPDATE species SET 
                name = :name,
                description = :description
             WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $species->getId(),
            ':name' => $species->getName(),
            ':description' => $species->getDescription()
        ]);
    }

    public function delete(int $id): bool
    {
        // Verifica si hay razas o mascotas que usen esta especie
        $breedCheck = $this->connection->prepare("SELECT COUNT(*) FROM breeds WHERE species_id = :id");
        $breedCheck->execute([':id' => $id]);
        $hasBreeds = (int)$breedCheck->fetchColumn() > 0;

        $petCheck = $this->connection->prepare("SELECT COUNT(*) FROM pets WHERE species_id = :id");
        $petCheck->execute([':id' => $id]);
        $hasPets = (int)$petCheck->fetchColumn() > 0;

        // No se puede eliminar si tiene dependencias
        if ($hasBreeds || $hasPets) {
            return false;
        }

        $stmt = $this->connection->prepare("DELETE FROM species WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function search(string $query): array
    {
        $stmt = $this->connection->prepare(
            "SELECT * FROM species 
             WHERE name LIKE :query
             ORDER BY name"
        );

        $searchQuery = "%$query%";
        $stmt->execute([':query' => $searchQuery]);

        $speciesList = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $speciesList[] = new Species(
                $data['id'],
                $data['name'],
                $data['description'] ?? null
            );
        }

        return $speciesList;
    }
}
