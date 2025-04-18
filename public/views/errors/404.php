<?php
$title = 'Página no Encontrada - Veterinaria';
$pageTitle = 'Error 404';
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/sidebar.php';
?>

<div class="flex-1 flex flex-col overflow-hidden">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
        <div class="flex justify-center items-center h-full">
            <div class="text-center">
                <h1 class="text-5xl font-bold text-gray-800 mb-4">404</h1>
                <p class="text-xl text-gray-600 mb-6">Página no encontrada</p>
                <a href="/" class="text-blue-600 hover:text-blue-800">
                    Volver a inicio
                </a>
            </div>
        </div>
    </main>
</div>

<script src="/js/global/scripts.js"></script>

<?php
include __DIR__ . '/../partials/footer.php';
?>