<?php

namespace VetApp\Domain\Entities;

class Pet
{

    public function __construct(
        private int $id,
        private string $name,
        private int $species_id,
        private ?int $breed_id,
        private string $gender,
        private string $life_stage,
        private float $weight,
        private int $client_id
    ) {}

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpeciesId(): int
    {
        return $this->species_id;
    }

    public function getBreedId(): ?int
    {
        return $this->breed_id;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getLifeStage(): string
    {
        return $this->life_stage;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getClientId(): int
    {
        return $this->client_id;
    }

    // Setters
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSpeciesId(int $species_id): void
    {
        $this->species_id = $species_id;
    }

    public function setBreedId(?int $breed_id): void
    {
        $this->breed_id = $breed_id;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function setLifeStage(string $life_stage): void
    {
        $this->life_stage = $life_stage;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function setClientId(int $client_id): void
    {
        $this->client_id = $client_id;
    }
}
