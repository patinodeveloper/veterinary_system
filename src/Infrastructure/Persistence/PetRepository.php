<?php

namespace VetApp\Infrastructure\Persistence;

use VetApp\Domain\Entities\Pet;
use VetApp\Domain\Repositories\PetRepositoryInterface;
use Config\Database;
use PDO;

class PetRepository implements PetRepositoryInterface
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function find(int $id): ?Pet
    {
        $stmt = $this->connection->prepare("SELECT * FROM pets WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Pet(
            $data['id'],
            $data['name'],
            $data['species'],
            $data['breed'],
            $data['gender'],
            $data['life_stage'] ?? 'JOVEN ADULTO',
            $data['weight'],
            $data['client_id']
        ) : null;
    }

    public function findAll(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->connection->prepare(
            "SELECT * FROM pets
             LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $pets = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pet = new Pet(
                $data['id'],
                $data['name'],
                $data['species'],
                $data['breed'],
                $data['gender'],
                $data['life_stage'] ?? 'No especificada',
                $data['weight'],
                $data['client_id']
            );
            $pets[] = $pet;
        }

        return $pets;
    }

    public function countAll(): int
    {
        $stmt = $this->connection->query("SELECT COUNT(*) as total FROM pets");
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function save(Pet $pet): int
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO pets (name, species, breed, gender, life_stage, weight, client_id) 
             VALUES (:name, :species, :breed, :gender, :life_stage, :weight, :client_id)"
        );

        $stmt->execute([
            ':name' => $pet->getName(),
            ':species' => $pet->getSpecies(),
            ':breed' => $pet->getBreed(),
            ':gender' => $pet->getGender(),
            ':life_stage' => $pet->getLifeStage(),
            ':weight' => $pet->getWeight(),
            ':client_id' => $pet->getClientId()
        ]);

        return $this->connection->lastInsertId();
    }

    public function update(Pet $pet): bool
    {
        $stmt = $this->connection->prepare(
            "UPDATE pets SET 
                name = :name,
                species = :species,
                breed = :breed,
                gender = :gender,
                life_stage = :life_stage,
                weight = :weight,
                client_id = :client_id
             WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $pet->getId(),
            ':name' => $pet->getName(),
            ':species' => $pet->getSpecies(),
            ':breed' => $pet->getBreed(),
            ':gender' => $pet->getGender(),
            ':life_stage' => $pet->getLifeStage(),
            ':weight' => $pet->getWeight(),
            ':client_id' => $pet->getClientId()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM pets WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function search(string $query, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->connection->prepare(
            "SELECT * FROM pets 
             WHERE name LIKE :query OR species LIKE :query OR breed LIKE :query
             ORDER BY name
             LIMIT :limit OFFSET :offset"
        );

        $searchQuery = "%$query%";
        $stmt->bindValue(':query', $searchQuery);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $pets = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pets[] = new Pet(
                $data['id'],
                $data['name'],
                $data['species'],
                $data['breed'],
                $data['gender'],
                $data['life_stage'],
                $data['weight'],
                $data['client_id']
            );
        }

        return $pets;
    }

    public function countSearch(string $query): int
    {
        $stmt = $this->connection->prepare(
            "SELECT COUNT(*) as total FROM pets 
             WHERE name LIKE :query OR species LIKE :query OR breed LIKE :query"
        );

        $searchQuery = "%$query%";
        $stmt->execute([':query' => $searchQuery]);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function findByClientId(int $clientId): array
    {
        $stmt = $this->connection->prepare(
            "SELECT * FROM pets WHERE client_id = :client_id ORDER BY name"
        );
        $stmt->execute([':client_id' => $clientId]);

        $pets = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pets[] = new Pet(
                $data['id'],
                $data['name'],
                $data['species'],
                $data['breed'],
                $data['gender'],
                $data['life_stage'] ?? 'No especificada',
                $data['weight'],
                $data['client_id']
            );
        }

        return $pets;
    }

    public function countByClientId(int $clientId): int
    {
        $stmt = $this->connection->prepare(
            "SELECT COUNT(*) as total FROM pets WHERE client_id = :client_id"
        );
        $stmt->execute([':client_id' => $clientId]);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
