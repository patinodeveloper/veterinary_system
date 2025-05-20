/**
 * Actualiza todos los formularios de eliminacion para usar SweetAlert2 como confirmación
 */
document.addEventListener('DOMContentLoaded', function () {
    // Busca todos los botones/enlaces de eliminación
    document.querySelectorAll('form[action*="/delete"]').forEach(form => {
        // Elimina el atributo onclick si existe
        form.querySelector('button[type="submit"]')?.removeAttribute('onclick');

        // Agrega un nuevo listener de eventos
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;

            // Mostrar dialogo de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar el formulario
                    form.submit();
                }
            });
        });
    });

    // Maneja enlaces directos con confirmación que tengan data-confirm
    document.querySelectorAll('[data-confirm]').forEach(element => {
        element.addEventListener('click', function (e) {
            e.preventDefault();

            const href = this.getAttribute('href');
            const message = this.getAttribute('data-confirm') || '¿Estás seguro?';

            Swal.fire({
                title: '¿Estás seguro?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed && href) {
                    window.location.href = href;
                }
            });
        });
    });
});