<?php

namespace VetApp\Infrastructure\Auth;

use VetApp\Domain\Entities\User;

class SessionAuth
{
    public function login(User $user): void
    {
        session_start();
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'role' => $user->getRole()
        ];
    }

    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public function isAuthenticated(): bool
    {
        session_start();
        return isset($_SESSION['user']);
    }

    public function getUser(): ?array
    {
        session_start();
        return $_SESSION['user'] ?? null;
    }
}
