<?php

namespace VetApp\Domain\Entities;

class Breed
{
    public function __construct(
        private int $id,
        private string $name,
        private int $species_id,
    ) {}

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // Setters
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSpeciesId(): int
    {
        return $this->species_id;
    }

    public function setSpeciesId(int $species_id): void
    {
        $this->species_id = $species_id;
    }
}
