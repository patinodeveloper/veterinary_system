<?php
$title = 'Editar Cliente - Veterinaria';
$pageTitle = 'Editar Cliente';
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
?>

<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <!-- Contenido principal -->
    <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
        <div class="flex justify-center items-center min-h-full">
            <div class="w-full max-w-md">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h1 class="text-2xl font-bold text-center mb-6">Editar Cliente</h1>

                    <form action="/clients/<?= $client->getId() ?>" method="POST">
                        <input type="hidden" name="_method" value="PUT">

                        <div class="space-y-6">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="firstName" name="firstName" required
                                    value="<?= htmlspecialchars($client->getFirstName()) ?>"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Nombre">
                            </div>

                            <div class="relative mt-4">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-tag text-gray-400"></i>
                                </div>
                                <input type="text" id="lastName" name="lastName" required
                                    value="<?= htmlspecialchars($client->getLastName()) ?>"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Apellido">
                            </div>

                            <div class="relative mt-4">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" id="phone" name="phone" required
                                    value="<?= htmlspecialchars($client->getPhone()) ?>"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Teléfono">
                            </div>

                            <div class="relative mt-4">
                                <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <textarea id="address" name="address" rows="3" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Dirección"><?= htmlspecialchars($client->getAddress()) ?>
                                </textarea>
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <a href="/clients/<?= $client->getId() ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Cancelar</a>
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                    <i class="fas fa-save mr-2"></i> Actualizar Cliente
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
include __DIR__ . '/../partials/scripts.php';
include __DIR__ . '/../partials/footer.php';
