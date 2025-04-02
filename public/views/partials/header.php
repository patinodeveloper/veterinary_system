<?php
require_once __DIR__ . '/../../../src/Interfaces/Http/Middleware/AuthMiddleware.php';

use VetApp\Infrastructure\Auth\SessionAuth;
use VetApp\Interfaces\Http\Middleware\AuthMiddleware;

$sessionAuth = new SessionAuth();
$authMiddleware = new AuthMiddleware($sessionAuth);
$authMiddleware->handle();

$user = $sessionAuth->getUser();

// Menú dinámico basado en el rol del usuario
$menuItems = [
    'admin' => [
        ['icon' => 'fas fa-home', 'text' => 'Dashboard', 'url' => '/dashboard'],
        ['icon' => 'fas fa-users', 'text' => 'Usuarios', 'url' => '/users'],
        ['icon' => 'fas fa-paw', 'text' => 'Mascotas', 'url' => '/pets'],
        ['icon' => 'fas fa-calendar-alt', 'text' => 'Citas', 'url' => '/appointments'],
        ['icon' => 'fas fa-file-medical', 'text' => 'Historiales', 'url' => '/records'],
        ['icon' => 'fas fa-cog', 'text' => 'Configuración', 'url' => '/settings']
    ],
    'vet' => [
        ['icon' => 'fas fa-home', 'text' => 'Dashboard', 'url' => '/dashboard'],
        ['icon' => 'fas fa-paw', 'text' => 'Mascotas', 'url' => '/pets'],
        ['icon' => 'fas fa-calendar-alt', 'text' => 'Mis Citas', 'url' => '/my-appointments'],
        ['icon' => 'fas fa-file-medical', 'text' => 'Historiales', 'url' => '/records']
    ],
    'assistant' => [
        ['icon' => 'fas fa-home', 'text' => 'Dashboard', 'url' => '/dashboard'],
        ['icon' => 'fas fa-paw', 'text' => 'Mascotas', 'url' => '/pets'],
        ['icon' => 'fas fa-calendar-alt', 'text' => 'Calendario', 'url' => '/calendar'],
        ['icon' => 'fas fa-user-plus', 'text' => 'Clientes', 'url' => '/clients']
    ]
];

$currentRole = $user['role'];
$currentMenu = $menuItems[$currentRole] ?? $menuItems['assistant'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'VetApp - Sistema Veterinario' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos para la sidebar */
        #sidebar {
            transition: all 0.3s ease-in-out;
            width: 16rem;
        }

        .sidebar-closed {
            transform: translateX(-100%);
            margin-left: -16rem;
        }

        .sidebar-open {
            transform: translateX(0);
            margin-left: 0;
        }

        /* Contenido principal ajustable */
        #main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        .content-expanded {
            margin-left: 16rem;
        }

        .content-collapsed {
            margin-left: 0;
        }

        @media (max-width: 767px) {
            .sidebar-open {
                position: fixed;
                z-index: 40;
            }

            .sidebar-closed {
                position: fixed;
                z-index: 40;
            }

            .content-expanded {
                margin-left: 0;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">