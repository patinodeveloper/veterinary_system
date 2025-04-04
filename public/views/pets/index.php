<?php
$title = 'Mascotas - Veterinaria';
$pageTitle = 'Mascotas';
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
?>

<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <!-- Contenido principal -->
    <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
        <div class="container mx-auto px-4 py-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Mascotas</h1>
            </div>

            <!-- Searchbar -->
            <form action="/pets/search" method="GET" class="mb-6">
                <div class="flex">
                    <input type="text" name="q" placeholder="Buscar mascotas..."
                        class="flex-1 px-4 py-2 border rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-r flex items-center">
                        <i class="fas fa-search mr-2"></i> Buscar
                    </button>
                </div>
            </form>

            <!-- Lista de mascotas -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Especie</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raza</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dueño</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($pets as $pet): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <?php $petIcon = $pet->getSpecies() === 'Perro' ? 'fa-dog' : ($pet->getSpecies() === 'Gato' ? 'fa-cat' : 'fa-paw'); ?>
                                            <i class="fas <?= $petIcon ?> text-gray-400 text-xl"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($pet->getName()) ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?= htmlspecialchars($pet->getGender()) ?> - <?= htmlspecialchars($pet->getLifeStage()) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($pet->getSpecies()) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($pet->getBreed()) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="/clients/<?= $pet->getClientId() ?>" class="text-blue-600 hover:text-blue-900">
                                        Ver dueño
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="/pets/<?= $pet->getId() ?>" class="text-blue-600 hover:text-blue-900" title="Ver">
                                            <i class="fas fa-eye text-base"></i>
                                        </a>
                                        <a href="/pets/<?= $pet->getId() ?>/edit" class="text-green-600 hover:text-green-900" title="Editar">
                                            <i class="fas fa-edit text-base"></i>
                                        </a>
                                        <form action="/pets/<?= $pet->getId() ?>/delete" method="POST" class="inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar"
                                                onclick="return confirm('¿Eliminar esta mascota?')">
                                                <i class="fas fa-trash-alt text-base"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Paginación -->
            <?php if ($totalPages > 1): ?>
                <div class="mt-6 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Mostrando página <?= $currentPage ?> de <?= $totalPages ?>
                        <?php if (isset($searchQuery)): ?>
                            - Resultados para "<?= htmlspecialchars($searchQuery) ?>"
                        <?php endif; ?>
                    </div>
                    <div class="flex space-x-2">
                        <?php
                        // Construir params base para los enlaces
                        $baseParams = [];
                        if (isset($searchQuery)) {
                            $baseParams['q'] = $searchQuery;
                        }

                        // Función para construir la URL
                        function buildUrl($page, $baseParams)
                        {
                            $params = array_merge($baseParams, ['page' => $page]);
                            return '?' . http_build_query($params);
                        }
                        ?>

                        <!-- Botón Anterior -->
                        <a href="<?= buildUrl(max(1, $currentPage - 1), $baseParams) ?>"
                            class="px-4 py-2 border rounded <?= $currentPage <= 1 ? 'bg-gray-100 cursor-not-allowed' : 'hover:bg-gray-50' ?>">
                            &larr; Anterior
                        </a>

                        <!-- Números de página -->
                        <?php
                        $start = max(1, $currentPage - 2);
                        $end = min($totalPages, $currentPage + 2);

                        for ($i = $start; $i <= $end; $i++): ?>
                            <a href="<?= buildUrl($i, $baseParams) ?>"
                                class="px-4 py-2 border rounded <?= $i == $currentPage ? 'bg-blue-500 text-white' : 'hover:bg-gray-50' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <!-- Botón Siguiente -->
                        <a href="<?= buildUrl(min($totalPages, $currentPage + 1), $baseParams) ?>"
                            class="px-4 py-2 border rounded <?= $currentPage >= $totalPages ? 'bg-gray-100 cursor-not-allowed' : 'hover:bg-gray-50' ?>">
                            Siguiente &rarr;
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php
include __DIR__ . '/../partials/scripts.php';
include __DIR__ . '/../partials/footer.php';
