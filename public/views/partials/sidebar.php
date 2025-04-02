<!-- Sidebar -->
<div id="sidebar" class="bg-blue-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 z-10 sidebar-closed md:sidebar-open md:relative">
    <!-- Logo/Brand -->
    <div class="text-white flex items-center space-x-2 px-4 mb-6">
        <i class="fas fa-paw text-2xl"></i>
        <span class="text-2xl font-extrabold">VetApp</span>
    </div>

    <!-- Menú -->
    <nav>
        <?php foreach ($currentMenu as $item): ?>
            <a href="<?= $item['url'] ?>" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white flex items-center">
                <i class="<?= $item['icon'] ?> mr-3"></i>
                <span><?= $item['text'] ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
</div>