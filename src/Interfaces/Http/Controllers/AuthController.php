<?php

namespace VetApp\Interfaces\Http\Controllers;

use VetApp\Application\Auth\LoginUseCase;
use VetApp\Infrastructure\Auth\SessionAuth;

class AuthController
{
    private LoginUseCase $loginUseCase;
    private SessionAuth $sessionAuth;

    public function __construct(LoginUseCase $loginUseCase, SessionAuth $sessionAuth)
    {
        $this->loginUseCase = $loginUseCase;
        $this->sessionAuth = $sessionAuth;
    }

    public function showLoginForm()
    {
        if ($this->sessionAuth->isAuthenticated()) {
            header('Location: /dashboard');
            exit();
        }

        include __DIR__ . '/../../../../public/views/auth/login.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->loginUseCase->execute($email, $password)) {
            header('Location: /dashboard');
            exit();
        }

        // Si falla el login
        $error = "Credenciales inválidas";
        include __DIR__ . '/../../../../public/views/auth/login.php';
    }

    public function logout()
    {
        $this->sessionAuth->logout();
        header('Location: /login');
        exit();
    }
}
