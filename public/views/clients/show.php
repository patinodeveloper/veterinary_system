<?php
$title = 'Detalle de Cliente - Veterinaria';
$pageTitle = 'Detalle de Cliente';
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
$pets = []; // remover prox
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

                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Mascotas</h2>
                                <?php if (count($pets) > 0): ?>
                                    <ul class="space-y-2">
                                        <?php foreach ($pets as $pet): ?>
                                            <li>
                                                <a href="/pets/<?= $pet->getId() ?>" class="text-blue-600 hover:text-blue-800">
                                                    <?= htmlspecialchars($pet->getName()) ?> (<?= htmlspecialchars($pet->getSpecies()) ?>)
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-gray-500">Este cliente no tiene mascotas registradas.</p>
                                <?php endif; ?>
                                <a href="/pets/create?client_id=<?= $client->getId() ?>" class="inline-block mt-3 text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                    <i class="fas fa-plus-circle mr-1"></i> Agregar mascota
                                </a>
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