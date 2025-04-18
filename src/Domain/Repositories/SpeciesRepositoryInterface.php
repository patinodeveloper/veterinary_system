<?php

namespace VetApp\Domain\Repositories;

use VetApp\Domain\Entities\Species;

interface SpeciesRepositoryInterface
{
    public function find(int $id): ?Species;
    public function findAll(int $page = 1, int $perPage = 10): array;
    public function countAll(): int;
    public function save(Species $species): int;
    public function update(Species $species): bool;
    public function delete(int $id): bool;
    public function search(string $query): array;
}
