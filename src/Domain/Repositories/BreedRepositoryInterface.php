<?php

namespace VetApp\Domain\Repositories;

use VetApp\Domain\Entities\Breed;

interface BreedRepositoryInterface
{
    public function find(int $id): ?Breed;
    public function findAll(int $page = 1, int $perPage = 10): array;
    public function countAll(): int;
    public function save(Breed $breed): int;
    public function update(Breed $breed): bool;
    public function delete(int $id): bool;
    public function search(string $query): array;
    public function findBySpeciesId(int $speciesId): array;
}
