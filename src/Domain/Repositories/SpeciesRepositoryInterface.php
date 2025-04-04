<?php

namespace VetApp\Domain\Repositories;

use VetApp\Domain\Entities\Species;

interface SpeciesRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): ?Species;
}
