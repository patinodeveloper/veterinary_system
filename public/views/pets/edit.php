<?php
$title = 'Editar Mascota - Veterinaria';
$pageTitle = 'Editar Mascota';
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
                    <h1 class="text-2xl font-bold text-center mb-6">Editar Mascota</h1>

                    <form action="/pets/<?= $pet->getId() ?>" method="POST">
                        <input type="hidden" name="_method" value="PUT">

                        <div class="space-y-6">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-paw text-gray-400"></i>
                                </div>
                                <input type="text" id="name" name="name" required
                                    value="<?= htmlspecialchars($pet->getName()) ?>"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Nombre de la mascota">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-dog text-gray-400"></i>
                                    </div>
                                    <select id="species" name="species" required
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                        <option value="Perro" <?= $pet->getSpecies() === 'Perro' ? 'selected' : '' ?>>Perro</option>
                                        <option value="Gato" <?= $pet->getSpecies() === 'Gato' ? 'selected' : '' ?>>Gato</option>
                                        <option value="Ave" <?= $pet->getSpecies() === 'Ave' ? 'selected' : '' ?>>Ave</option>
                                        <option value="Roedor" <?= $pet->getSpecies() === 'Roedor' ? 'selected' : '' ?>>Roedor</option>
                                        <option value="Reptil" <?= $pet->getSpecies() === 'Reptil' ? 'selected' : '' ?>>Reptil</option>
                                        <option value="Otro" <?= $pet->getSpecies() === 'Otro' ? 'selected' : '' ?>>Otro</option>
                                    </select>
                                </div>

                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-dna text-gray-400"></i>
                                    </div>
                                    <input type="text" id="breed" name="breed" required
                                        value="<?= htmlspecialchars($pet->getBreed()) ?>"
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Raza">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-venus-mars text-gray-400"></i>
                                    </div>
                                    <select id="gender" name="gender" required
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                        <option value="Macho" <?= $pet->getGender() === 'Macho' ? 'selected' : '' ?>>Macho</option>
                                        <option value="Hembra" <?= $pet->getGender() === 'Hembra' ? 'selected' : '' ?>>Hembra</option>
                                    </select>
                                </div>

                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-hourglass-half text-gray-400"></i>
                                    </div>
                                    <select id="life_stage" name="life_stage" required
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                        <option value="Cachorro" <?= $pet->getLifeStage() === 'Cachorro' ? 'selected' : '' ?>>Cachorro</option>
                                        <option value="Joven" <?= $pet->getLifeStage() === 'Joven' ? 'selected' : '' ?>>Joven</option>
                                        <option value="Adulto" <?= $pet->getLifeStage() === 'Adulto' ? 'selected' : '' ?>>Adulto</option>
                                        <option value="Senior" <?= $pet->getLifeStage() === 'Senior' ? 'selected' : '' ?>>Senior</option>
                                    </select>
                                </div>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-weight text-gray-400"></i>
                                </div>
                                <input type="text" id="weight" name="weight"
                                    value="<?= htmlspecialchars($pet->getWeight()) ?>"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Peso (kg)">
                            </div>

                            <div class="bg-blue-50 p-3 rounded-md text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i> Dueño actual:
                                <a href="/clients/<?= $pet->getClientId() ?>" class="font-medium hover:underline">
                                    Ver dueño
                                </a>
                            </div>

                            <div class="flex items-center justify-between pt-4">
                                <a href="/pets/<?= $pet->getId() ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Cancelar</a>
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                    <i class="fas fa-save mr-2"></i> Actualizar Mascota
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
