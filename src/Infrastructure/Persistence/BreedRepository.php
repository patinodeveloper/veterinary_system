<?php

namespace VetApp\Infrastructure\Persistence;

use VetApp\Domain\Entities\Breed;
use VetApp\Domain\Repositories\BreedRepositoryInterface;
use Config\Database;
use PDO;

class BreedRepository implements BreedRepositoryInterface
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function find(int $id): ?Breed
    {
        $stmt = $this->connection->prepare("SELECT * FROM breeds WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Breed(
            $data['id'],
            $data['name'],
            $data['species_id']
        ) : null;
    }

    public function findAll(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->connection->prepare(
            "SELECT b.*, s.name as species_name 
             FROM breeds b
             JOIN species s ON b.species_id = s.id
             ORDER BY s.name, b.name
             LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $breeds = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $breed = new Breed(
                $data['id'],
                $data['name'],
                $data['species_id']
            );
            $breeds[] = $breed;
        }

        return $breeds;
    }

    public function countAll(): int
    {
        $stmt = $this->connection->query("SELECT COUNT(*) as total FROM breeds");
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function save(Breed $breed): int
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO breeds (name, species_id) 
             VALUES (:name, :species_id)"
        );

        $stmt->execute([
            ':name' => $breed->getName(),
            ':species_id' => $breed->getSpeciesId()
        ]);

        return $this->connection->lastInsertId();
    }

    public function update(Breed $breed): bool
    {
        $stmt = $this->connection->prepare(
            "UPDATE breeds SET 
                name = :name,
                species_id = :species_id
             WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $breed->getId(),
            ':name' => $breed->getName(),
            ':species_id' => $breed->getSpeciesId()
        ]);
    }

    public function delete(int $id): bool
    {
        // Verifica si hay mascotas que usen esta raza
        $petCheck = $this->connection->prepare("SELECT COUNT(*) FROM pets WHERE breed_id = :id");
        $petCheck->execute([':id' => $id]);
        $hasPets = (int)$petCheck->fetchColumn() > 0;

        // No se puede eliminar si tiene dependencias
        if ($hasPets) {
            return false;
        }

        // Elimina la raza
        $stmt = $this->connection->prepare("DELETE FROM breeds WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function search(string $query): array
    {
        $stmt = $this->connection->prepare(
            "SELECT b.*, s.name as species_name 
             FROM breeds b
             JOIN species s ON b.species_id = s.id
             WHERE b.name LIKE :query
             ORDER BY s.name, b.name"
        );

        $searchQuery = "%$query%";
        $stmt->execute([':query' => $searchQuery]);

        $breeds = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $breeds[] = new Breed(
                $data['id'],
                $data['name'],
                $data['species_id']
            );
        }

        return $breeds;
    }

    /** Obtiene las razas por ID de especie */
    public function findBySpeciesId(int $speciesId): array
    {
        $stmt = $this->connection->prepare(
            "SELECT * FROM breeds 
             WHERE species_id = :species_id
             ORDER BY name"
        );
        $stmt->execute([':species_id' => $speciesId]);

        $breeds = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $breeds[] = new Breed(
                $data['id'],
                $data['name'],
                $data['species_id']
            );
        }

        return $breeds;
    }
}
