<script>
    // Control de la sidebar
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    // Estado inicial basado en el tamaño de pantalla
    let sidebarOpen = window.innerWidth >= 768;
    updateSidebarState();

    // Función para actualizar el estado visual
    function updateSidebarState() {
        if (sidebarOpen) {
            sidebar.classList.remove('sidebar-closed');
            sidebar.classList.add('sidebar-open');
        } else {
            sidebar.classList.remove('sidebar-open');
            sidebar.classList.add('sidebar-closed');
        }
    }

    // Evento para el botón de toggle
    sidebarToggle.addEventListener('click', () => {
        sidebarOpen = !sidebarOpen;
        updateSidebarState();
        localStorage.setItem('sidebarOpen', sidebarOpen);
    });

    // Redimensionamiento de pantalla
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768 && !sidebarOpen) {
            sidebarOpen = true;
            updateSidebarState();
        } else if (window.innerWidth < 768 && sidebarOpen) {
            sidebarOpen = false;
            updateSidebarState();
        }
    });

    // Cargar preferencia guardada
    const savedSidebarState = localStorage.getItem('sidebarOpen');
    if (savedSidebarState !== null) {
        sidebarOpen = savedSidebarState === 'true';
        updateSidebarState();
    }

    // Menú desplegable del usuario
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');

    userMenuButton.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', (e) => {
        if (!userMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
            userMenu.classList.add('hidden');
        }
    });

    // Marcar el ítem de menú activo
    document.querySelectorAll('#sidebar a').forEach(link => {
        if (link.getAttribute('href') === window.location.pathname) {
            link.classList.add('bg-blue-700', 'font-semibold');
        }
    });
</script>