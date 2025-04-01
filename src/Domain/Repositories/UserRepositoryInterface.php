<?php

namespace VetApp\Domain\Repositories;

use VetApp\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function save(User $user): void;
}
