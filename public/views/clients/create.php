<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Nuevo Cliente</h1>

    <form action="/clients" method="POST" class="max-w-md">
        <div class="mb-4">
            <label for="firstName" class="block text-gray-700 mb-2">Nombre</label>
            <input type="text" id="firstName" name="firstName" required
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="lastName" class="block text-gray-700 mb-2">Apellido</label>
            <input type="text" id="lastName" name="lastName" required
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-gray-700 mb-2">Teléfono</label>
            <input type="text" id="phone" name="phone" required
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 mb-2">Dirección</label>
            <textarea id="address" name="address" rows="3"
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <div class="flex items-center justify-between">
            <a href="/clients" class="text-gray-600 hover:text-gray-800">Cancelar</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Guardar Cliente
            </button>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>