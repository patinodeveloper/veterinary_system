<?php
$title = 'Detalle de Cliente - Veterinaria';
$pageTitle = 'Detalle de Cliente';
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
// $pets = []; // remover prox
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
                            <h1 class="text-2xl font-bold text-white"><?= htmlspecialchars($client->getFirstName() . ' ' . $client->getLastName()) ?></h1>
                            <div class="flex space-x-2">
                                <a href="/clients/<?= $client->getId() ?>/edit" class="text-white hover:text-blue-200">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Información del cliente -->
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <p class="flex items-center">
                                    <i class="fas fa-phone text-gray-500 mr-2 w-5"></i>
                                    <span class="font-medium">Teléfono:</span>
                                    <span class="ml-1"><?= htmlspecialchars($client->getPhone()) ?></span>
                                </p>
                                <p class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-gray-500 mr-2 mt-1 w-5"></i>
                                    <span>
                                        <span class="font-medium">Dirección:</span>
                                        <span class="ml-1 block"><?= htmlspecialchars($client->getAddress()) ?></span>
                                    </span>
                                </p>
                            </div>

                            <!-- Sección de Mascotas Mejorada -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-3">
                                    <h2 class="text-lg font-semibold text-gray-700">
                                        <i class="fas fa-paw mr-1"></i> Mascotas (<?= count($pets) ?>)
                                    </h2>
                                    <a href="/pets/create?client_id=<?= $client->getId() ?>"
                                        class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded flex items-center">
                                        <i class="fas fa-plus-circle mr-1"></i> Nueva
                                    </a>
                                </div>

                                <?php if (count($pets) > 0): ?>
                                    <div class="space-y-3">
                                        <?php foreach ($pets as $pet): ?>
                                            <div class="bg-white p-3 rounded-md shadow-sm hover:shadow-md transition-shadow">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <a href="/pets/<?= $pet->getId() ?>" class="font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                                            <?php
                                                            $icon = match ($pet->getSpecies()) {
                                                                'Perro' => 'fa-dog',
                                                                'Gato' => 'fa-cat',
                                                                default => 'fa-paw'
                                                            };
                                                            ?>
                                                            <i class="fas <?= $icon ?> mr-2 text-gray-400"></i>
                                                            <?= htmlspecialchars($pet->getName()) . ' - ' . htmlspecialchars($pet->getSpecies()) ?>
                                                        </a>
                                                        <div class="text-sm text-gray-600 mt-1">
                                                            <span class="inline-block bg-gray-100 rounded-full px-2 py-0.5 mr-2">
                                                                <?= htmlspecialchars($pet->getBreed()) ?>
                                                            </span>
                                                            <span class="inline-block bg-gray-100 rounded-full px-2 py-0.5">
                                                                <?= htmlspecialchars($pet->getLifeStage()) ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <a href="/pets/<?= $pet->getId() ?>/edit"
                                                        class="text-gray-400 hover:text-gray-600 ml-2"
                                                        title="Editar mascota">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="fas fa-paw text-gray-300 text-4xl mb-2"></i>
                                        <p class="text-gray-500">No hay mascotas registradas</p>
                                        <a href="/pets/create?client_id=<?= $client->getId() ?>"
                                            class="inline-block mt-2 text-blue-500 hover:text-blue-700 text-sm">
                                            Agregar primera mascota
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de citas -->
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
                            <p class="text-gray-500">No hay citas programadas.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="/clients" class="text-blue-600 hover:text-blue-800 flex items-center">
                        <i class="fas fa-arrow-circle-left mr-2"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
include __DIR__ . '/../partials/scripts.php';
include __DIR__ . '/../partials/footer.php';
?>