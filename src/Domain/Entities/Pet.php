<?php

namespace VetApp\Domain\Entities;

class Pet
{
    private int $id;
    private string $name;
    private string $species;
    private string $breed;
    private string $gender;
    private string $life_stage;
    private string $weight;
    private int $client_id;

    public function __construct(
        int $id,
        string $name,
        string $species,
        string $breed,
        string $gender,
        string $life_stage,
        string $weight,
        int $client_id
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->species = $species;
        $this->breed = $breed;
        $this->gender = $gender;
        $this->life_stage = $life_stage;
        $this->weight = $weight;
        $this->client_id = $client_id;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpecies(): string
    {
        return $this->species;
    }

    public function getBreed(): string
    {
        return $this->breed;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getLifeStage(): string
    {
        return $this->life_stage;
    }

    public function getWeight(): string
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

    public function setSpecies(string $species): void
    {
        $this->species = $species;
    }

    public function setBreed(string $breed): void
    {
        $this->breed = $breed;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function setLifeStage(string $life_stage): void
    {
        $this->life_stage = $life_stage;
    }

    public function setWeight(string $weight): void
    {
        $this->weight = $weight;
    }

    public function setClientId(int $client_id): void
    {
        $this->client_id = $client_id;
    }
}
