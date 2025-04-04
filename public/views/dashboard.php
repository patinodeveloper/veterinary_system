<?php
$title = 'Dashboard - Veterinaria';
$pageTitle = 'Dashboard';
include __DIR__ . '/partials/header.php';
include __DIR__ . '/partials/sidebar.php';
?>

<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <?php include __DIR__ . '/partials/navbar.php'; ?>

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
                        <p class="text-gray-600">Contenido principal en desarrollo</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
include __DIR__ . '/partials/scripts.php';
include __DIR__ . '/partials/footer.php';
