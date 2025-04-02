<?php

namespace VetApp\Domain\Repositories;

use VetApp\Domain\Entities\Client;

interface ClientRepositoryInterface
{
    public function find(int $id): ?Client;
    public function findAll(int $page = 1, int $perPage = 10): array;
    public function countAll(): int;
    public function save(Client $client): int;
    public function update(Client $client): bool;
    public function delete(int $id): bool;
    public function search(string $query, int $page = 1, int $perPage = 10): array;
    public function countSearch(string $query): int;
}
