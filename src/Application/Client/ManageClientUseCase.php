<?php

namespace VetApp\Application\Client;

use VetApp\Domain\Entities\Client;
use VetApp\Domain\Repositories\ClientRepositoryInterface;

class ManageClientUseCase
{
    private ClientRepositoryInterface $repository;

    public function __construct(ClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getClient(int $id): ?Client
    {
        return $this->repository->find($id);
    }

    public function getAllClients(int $page = 1, int $perPage = 10): array
    {
        return [
            'data' => $this->repository->findAll($page, $perPage),
            'total' => $this->repository->countAll(),
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($this->repository->countAll() / $perPage)
        ];
    }

    public function createClient(
        string $firstName,
        string $lastName,
        string $phone,
        string $address
    ): int {
        $client = new Client(0, $firstName, $lastName, $phone, $address);
        return $this->repository->save($client);
    }

    public function updateClient(
        int $id,
        string $firstName,
        string $lastName,
        string $phone,
        string $address
    ): bool {
        $client = new Client($id, $firstName, $lastName, $phone, $address);
        return $this->repository->update($client);
    }

    public function deleteClient(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function searchClients(string $query, int $page = 1, int $perPage = 10): array
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
}
