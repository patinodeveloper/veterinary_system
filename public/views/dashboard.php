<?php
// Protección de ruta
require_once __DIR__ . '/../../src/Interfaces/Http/Middleware/AuthMiddleware.php';

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
    <title>Dashboard - Veterinaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos para la sidebar */
        #sidebar {
            transition: all 0.3s ease-in-out;
            width: 16rem;
            /* 64 = 16rem */
        }

        /* Clases para estado abierto/cerrado */
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

        /* Asegurar que el contenido no se salga en móviles */
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
        <!-- Sidebar -->
        <div id="sidebar" class="bg-blue-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 z-10 sidebar-closed md:sidebar-open md:relative">
            <!-- Logo/Brand -->
            <div class="text-white flex items-center space-x-2 px-4 mb-6">
                <i class="fas fa-paw text-2xl"></i>
                <span class="text-2xl font-extrabold">VetApp</span>
            </div>

            <!-- Menú -->
            <nav>
                <?php foreach ($currentMenu as $item): ?>
                    <a href="<?= $item['url'] ?>" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white flex items-center">
                        <i class="<?= $item['icon'] ?> mr-3"></i>
                        <span><?= $item['text'] ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <nav class="bg-white shadow-sm">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Botón hamburguesa - Siempre visible -->
                        <div class="flex items-center">
                            <button id="sidebarToggle" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>

                        <div class="flex items-center">
                            <span class="text-xl font-semibold">Veterinaria</span>
                        </div>

                        <div class="flex items-center">
                            <span class="mr-4 hidden md:block"><?= htmlspecialchars($user['name']) ?></span>
                            <div class="relative">
                                <button id="userMenuButton" class="flex items-center text-gray-600 hover:text-gray-800 focus:outline-none">
                                    <i class="fas fa-user-circle text-2xl"></i>
                                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                </button>
                                <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                                    <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                                    <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar Sesión</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-bold text-gray-900 mb-6">Bienvenido, <?= htmlspecialchars($user['firstName']) ?></h1>

                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Tarjetas de resumen -->
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                        <i class="fas fa-paw text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Mascotas</p>
                                        <h3 class="text-2xl font-bold">124</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                        <i class="fas fa-calendar-alt text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Citas Hoy</p>
                                        <h3 class="text-2xl font-bold">8</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                        <i class="fas fa-file-invoice-dollar text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Ingresos</p>
                                        <h3 class="text-2xl font-bold">$3,450</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección adicional -->
                        <div class="mt-8">
                            <h2 class="text-xl font-semibold mb-4">Actividad</h2>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-600">contenido principal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Control de la sidebar
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        // Estado inicial basado en el tamaño de pantalla
        let sidebarOpen = window.innerWidth >= 768;
        updateSidebarState();

        // Función para actualizar el estado visual
        function updateSidebarState() {
            if (sidebarOpen) {
                sidebar.classList.remove('sidebar-closed');
                sidebar.classList.add('sidebar-open');
            } else {
                sidebar.classList.remove('sidebar-open');
                sidebar.classList.add('sidebar-closed');
            }
        }

        // Evento para el botón de toggle
        sidebarToggle.addEventListener('click', () => {
            sidebarOpen = !sidebarOpen;
            updateSidebarState();

            // Guardar preferencia en localStorage
            localStorage.setItem('sidebarOpen', sidebarOpen);
        });

        // Evento para redimensionamiento de pantalla
        window.addEventListener('resize', () => {
            // Solo cambia automáticamente si es un cambio grande de tamaño
            if (window.innerWidth >= 768 && !sidebarOpen) {
                sidebarOpen = true;
                updateSidebarState();
            } else if (window.innerWidth < 768 && sidebarOpen) {
                sidebarOpen = false;
                updateSidebarState();
            }
        });

        // Cargar preferencia guardada
        const savedSidebarState = localStorage.getItem('sidebarOpen');
        if (savedSidebarState !== null) {
            sidebarOpen = savedSidebarState === 'true';
            updateSidebarState();
        }

        // Menú desplegable del usuario
        const userMenuButton = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (!userMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Marcar el ítem de menú activo
        document.querySelectorAll('#sidebar a').forEach(link => {
            if (link.getAttribute('href') === window.location.pathname) {
                link.classList.add('bg-blue-700', 'font-semibold');
            }
        });
    </script>
</body>

</html>