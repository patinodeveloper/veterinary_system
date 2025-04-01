<?php

namespace VetApp\Domain\Services;

use VetApp\Domain\Entities\User;
use VetApp\Domain\Repositories\UserRepositoryInterface;

class AuthService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(string $email, string $password): ?User
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user && $user->verifyPassword($password)) {
            return $user;
        }

        return null;
    }
}
