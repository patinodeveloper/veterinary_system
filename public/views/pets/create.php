<?php
$title = 'Nueva Mascota - Veterinaria';
$pageTitle = 'Nueva Mascota';
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
                    <div class="text-center mb-6">
                        <img src="/img/pets.png" alt="Pet" class="mx-auto w-32 h-32">
                    </div>
                    <h1 class="text-2xl font-bold text-center mb-6">Registrar Nueva Mascota</h1>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <?= htmlspecialchars($_GET['error']) ?>
                        </div>
                    <?php endif; ?>

                    <form action="/pets" method="POST" class="space-y-6">
                        <input type="hidden" name="client_id" value="<?= htmlspecialchars($clientId ?? '') ?>">

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-paw text-gray-400"></i>
                            </div>
                            <input type="text" id="name" name="name" required
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Nombre de la mascota">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-dog text-gray-400"></i>
                                </div>
                                <select id="species_id" name="species_id" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                    <option value="">Seleccione especie</option>
                                    <?php foreach ($speciesList as $species): ?>
                                        <option value="<?= $species->getId() ?>"
                                            <?= (isset($speciesId) && $species->getId() == $speciesId) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($species->getName()) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-dna text-gray-400"></i>
                                </div>
                                <select id="breed_id" name="breed_id"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                    <option value="">No especificada</option>
                                    <?php if (!empty($breedsList)): ?>
                                        <?php foreach ($breedsList as $breed): ?>
                                            <option value="<?= $breed->getId() ?>">
                                                <?= htmlspecialchars($breed->getName()) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-venus-mars text-gray-400"></i>
                                </div>
                                <select id="gender" name="gender" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                    <option value="">Género</option>
                                    <option value="M">Macho</option>
                                    <option value="H">Hembra</option>
                                </select>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-hourglass-half text-gray-400"></i>
                                </div>
                                <select id="life_stage" name="life_stage" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                    <option value="">Etapa de vida</option>
                                    <option value="Cria">Cria</option>
                                    <option value="Joven">Joven</option>
                                    <option value="Adulto">Adulto</option>
                                    <option value="Anciano">Anciano</option>
                                </select>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-weight text-gray-400"></i>
                            </div>
                            <input type="number" step="0.1" id="weight" name="weight" required
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Peso (kg)">
                        </div>

                        <?php if (!empty($clientId)): ?>
                            <div class="bg-blue-50 p-3 rounded-md text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i> Esta mascota será registrada para <strong><?= htmlspecialchars($client->getFirstName() . ' ' . $client->getLastName()) ?></strong>.
                            </div>
                        <?php else: ?>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <select id="client_id" name="client_id" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                    <option value="">Seleccione un dueño</option>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?= $client->getId() ?>">
                                            <?= htmlspecialchars($client->getFirstName() . ' ' . $client->getLastName()) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <div class="flex items-center justify-between pt-4">
                            <a href="/pets" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Cancelar</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i> Guardar Mascota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="/js/global/scripts.js"></script>
<script src="/js/pets/load_breeds.js"></script>

<?php
include __DIR__ . '/../partials/footer.php';
?>