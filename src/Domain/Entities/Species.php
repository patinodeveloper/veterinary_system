<?php

namespace VetApp\Domain\Entities;

class Species
{
    public function __construct(
        private int $id,
        private string $name,
        private ?string $description
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    // Setters
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
