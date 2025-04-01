<?php

namespace VetApp\Application\Auth;

use VetApp\Domain\Services\AuthService;
use VetApp\Infrastructure\Auth\SessionAuth;

class LoginUseCase
{
    private AuthService $authService;
    private SessionAuth $sessionAuth;

    public function __construct(AuthService $authService, SessionAuth $sessionAuth)
    {
        $this->authService = $authService;
        $this->sessionAuth = $sessionAuth;
    }

    public function execute(string $email, string $password): bool
    {
        $user = $this->authService->authenticate($email, $password);

        if ($user) {
            $this->sessionAuth->login($user);
            return true;
        }

        return false;
    }
}
