<?php

namespace VetApp\Interfaces\Http\Middleware;

use VetApp\Infrastructure\Auth\SessionAuth;

class AuthMiddleware
{
    private SessionAuth $sessionAuth;

    public function __construct(SessionAuth $sessionAuth)
    {
        $this->sessionAuth = $sessionAuth;
    }

    public function handle(): void
    {
        if (!$this->sessionAuth->isAuthenticated()) {
            header('Location: /login');
            exit();
        }
    }
}
