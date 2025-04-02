<!-- Navbar -->
<nav class="bg-white shadow-sm">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Menu hamburguesa -->
            <div class="flex items-center">
                <button id="sidebarToggle" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <div class="flex items-center">
                <span class="text-xl font-semibold"><?= $pageTitle ?? 'Veterinaria' ?></span>
            </div>

            <div class="flex items-center">
                <span class="mr-4 hidden md:block"><?= htmlspecialchars($user['firstName']) ?></span>
                <div class="relative">
                    <button id="userMenuButton" class="flex items-center text-gray-600 hover:text-gray-800 focus:outline-none">
                        <i class="fas fa-user-circle text-2xl"></i>
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                        <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>