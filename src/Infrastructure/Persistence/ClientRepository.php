<?php

namespace VetApp\Infrastructure\Persistence;

use VetApp\Domain\Entities\Client;
use VetApp\Domain\Repositories\ClientRepositoryInterface;
use Config\Database;
use PDO;

class ClientRepository implements ClientRepositoryInterface
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function find(int $id): ?Client
    {
        $stmt = $this->connection->prepare("SELECT * FROM clients WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Client(
            $data['id'],
            $data['firstName'],
            $data['lastName'],
            $data['phone'],
            $data['address']
        ) : null;
    }

    public function findAll(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->connection->prepare(
            "SELECT * FROM clients
             LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $clients = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = new Client(
                $data['id'],
                $data['firstName'],
                $data['lastName'],
                $data['phone'],
                $data['address']
            );
        }

        return $clients;
    }

    public function countAll(): int
    {
        $stmt = $this->connection->query("SELECT COUNT(*) as total FROM clients");
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function save(Client $client): int
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO clients (firstName, lastName, phone, address) 
             VALUES (:firstName, :lastName, :phone, :address)"
        );

        $stmt->execute([
            ':firstName' => $client->getFirstName(),
            ':lastName' => $client->getLastName(),
            ':phone' => $client->getPhone(),
            ':address' => $client->getAddress()
        ]);

        return $this->connection->lastInsertId();
    }

    public function update(Client $client): bool
    {
        $stmt = $this->connection->prepare(
            "UPDATE clients SET 
                firstName = :firstName,
                lastName = :lastName,
                phone = :phone,
                address = :address
             WHERE id = :id"
        );

        return $stmt->execute([
            ':id' => $client->getId(),
            ':firstName' => $client->getFirstName(),
            ':lastName' => $client->getLastName(),
            ':phone' => $client->getPhone(),
            ':address' => $client->getAddress()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM clients WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function search(string $query, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->connection->prepare(
            "SELECT * FROM clients 
         WHERE firstName LIKE :query OR lastName LIKE :query OR phone LIKE :query
         ORDER BY lastName, firstName
         LIMIT :limit OFFSET :offset"
        );

        $searchQuery = "%$query%";
        $stmt->bindValue(':query', $searchQuery);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $clients = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = new Client(
                $data['id'],
                $data['firstName'],
                $data['lastName'],
                $data['phone'],
                $data['address']
            );
        }

        return $clients;
    }

    public function countSearch(string $query): int
    {
        $stmt = $this->connection->prepare(
            "SELECT COUNT(*) as total FROM clients 
         WHERE firstName LIKE :query OR lastName LIKE :query OR phone LIKE :query"
        );

        $searchQuery = "%$query%";
        $stmt->execute([':query' => $searchQuery]);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function findByPetId(int $id): ?Client
    {
        $stmt = $this->connection->prepare("SELECT c.* FROM clients c JOIN pets p ON c.id = p.client_id WHERE p.id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Client(
            $data['id'],
            $data['firstName'],
            $data['lastName'],
            $data['phone'],
            $data['address']
        ) : null;
    }
}
