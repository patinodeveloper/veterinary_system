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

                    <form action="/pets" method="POST" class="space-y-6">
                        <input type="hidden" name="client_id" value="<?= htmlspecialchars($_GET['client_id'] ?? '') ?>">

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
                                <select id="species" name="species" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                    <option value="">Especie</option>
                                    <option value="Perro">Perro</option>
                                    <option value="Gato">Gato</option>
                                    <option value="Ave">Ave</option>
                                    <option value="Roedor">Roedor</option>
                                    <option value="Reptil">Reptil</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-dna text-gray-400"></i>
                                </div>
                                <input type="text" id="breed" name="breed" required
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
                                    <option value="Cria">Cría</option>
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
                            <input type="text" id="weight" name="weight"
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Peso (kg)">
                        </div>

                        <?php if (!empty($_GET['client_id'])): ?>
                            <div class="bg-blue-50 p-3 rounded-md text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i> Esta mascota será registrada para el cliente seleccionado.
                            </div>
                        <?php else: ?>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <select id="client_id" name="client_id" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                    <option value="">Seleccione un dueño</option>
                                    <!-- Aquí deberías cargar la lista de clientes desde la base de datos -->
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

<?php
include __DIR__ . '/../partials/scripts.php';
include __DIR__ . '/../partials/footer.php';
