<?php

namespace VetApp\Domain\Repositories;

use VetApp\Domain\Entities\Pet;

interface PetRepositoryInterface
{
    public function find(int $id): ?Pet;
    public function findAll(int $page = 1, int $perPage = 10): array;
    public function countAll(): int;
    public function save(Pet $pet): int;
    public function update(Pet $pet): bool;
    public function delete(int $id): bool;
    public function search(string $query, int $page = 1, int $perPage = 10): array;
    public function countSearch(string $query): int;
     public function findByClientId(int $clientId): array;
    public function countByClientId(int $clientId): int;
}
