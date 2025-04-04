<?php

namespace VetApp\Domain\Repositories;

use VetApp\Domain\Entities\Breed;

interface BreedRepositoryInterface
{
    public function findBySpecies(int $species_id): array;
    public function findById(int $id): ?Breed;
}
