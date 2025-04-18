<?php
$title = 'Detalle de Mascota - Veterinaria';
$pageTitle = 'Detalle de Mascota';
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$appointments = []; // remover prox
?>

<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <!-- Contenido principal -->
    <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
        <div class="flex justify-center">
            <div class="w-full max-w-3xl">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <!-- Encabezado -->
                    <div class="bg-blue-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <?php $petIcon = $pet['species_name'] === 'Perro' ? 'fa-dog' : ($pet['species_name'] === 'Gato' ? 'fa-cat' : 'fa-paw'); ?>
                                <i class="fas <?= $petIcon ?> text-white text-2xl mr-3"></i>
                                <h1 class="text-2xl font-bold text-white"><?= htmlspecialchars($pet['name']) ?></h1>
                            </div>
                            <div class="flex space-x-2">
                                <a href="/pets/<?= $pet['id'] ?>/edit" class="text-white hover:text-blue-200">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Informacion de la mascota -->
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Información Básica</h2>
                                    <div class="space-y-2">
                                        <p class="flex items-center">
                                            <i class="fas fa-dna text-gray-500 mr-2 w-5"></i>
                                            <span class="font-medium">Especie:</span>
                                            <span class="ml-1"><?= htmlspecialchars($pet['species_name']) ?></span>
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-dna text-gray-500 mr-2 w-5"></i>
                                            <span class="font-medium">Raza:</span>
                                            <span class="ml-1"><?= htmlspecialchars($pet['breed_name']) ?></span>
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-venus-mars text-gray-500 mr-2 w-5"></i>
                                            <span class="font-medium">Género:</span>
                                            <span class="ml-1"><?= htmlspecialchars($pet['gender']) ?></span>
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-hourglass-half text-gray-500 mr-2 w-5"></i>
                                            <span class="font-medium">Etapa de vida:</span>
                                            <span class="ml-1"><?= htmlspecialchars($pet['life_stage']) ?></span>
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-weight text-gray-500 mr-2 w-5"></i>
                                            <span class="font-medium">Peso:</span>
                                            <span class="ml-1"><?= htmlspecialchars($pet['weight']) ?> kg</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Dueño</h2>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <a href="/clients/<?= $pet['client_id'] ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                                        <i class="fas fa-user mr-1"></i> Ver información del dueño
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historial médico -->
                    <div class="px-6 py-4 border-t">
                        <h2 class="text-lg font-semibold text-gray-700 mb-3">Historial Médico</h2>
                        <div class="bg-yellow-50 p-4 rounded-md text-yellow-800 text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i> Módulo en desarrollo. Próximamente podrás ver el historial médico completo de esta mascota.
                        </div>
                    </div>

                    <!-- Próximas citas -->
                    <div class="px-6 py-4 border-t">
                        <h2 class="text-lg font-semibold text-gray-700 mb-3">Próximas Citas</h2>
                        <?php if (count($appointments) > 0): ?>
                            <div class="space-y-3">
                                <?php foreach ($appointments as $appointment): ?>
                                    <div class="bg-gray-50 p-3 rounded-md">
                                        <p class="font-medium"><?= htmlspecialchars($appointment->getDateTime()->format('d/m/Y H:i')) ?></p>
                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($appointment->getReason()) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="bg-blue-50 p-3 rounded-md text-blue-800 text-sm">
                                <i class="fas fa-info-circle mr-1"></i> No hay citas programadas para esta mascota.
                                <a href="/appointments/create?pet_id=<?= $pet['id'] ?>" class="text-blue-600 hover:text-blue-800 font-medium ml-1">
                                    Agendar cita
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="/pets" class="text-blue-600 hover:text-blue-800 flex items-center">
                        <i class="fas fa-arrow-circle-left mr-2"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="/js/global/scripts.js"></script>

<?php
include __DIR__ . '/../partials/footer.php';
