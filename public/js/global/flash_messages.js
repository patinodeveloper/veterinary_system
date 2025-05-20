/**
 * Script para manejar los mensajes flash con SweetAlert2
 */
document.addEventListener("DOMContentLoaded", function () {
    // Verifica si hay mensajes flash
    if (window.flashMessages && window.flashMessages.length > 0) {
        // Procesar cada mensaje
        processMessages(window.flashMessages);
    }
});

/**
 * Procesa la cola de mensajes flash secuencialmente
 * @param {Array} messages Mensajes a procesar
 * @param {number} index Índice actual
 */
function processMessages(messages, index = 0) {
    // Si hemos procesado todos los mensajes: salir
    if (index >= messages.length) return;

    const message = messages[index];
    const config = message.config || {};

    // Configuracion del SweetAlert2
    const swalConfig = {
        title: config.title || "Notificación",
        text: message.message,
        icon: config.icon || "info",
        confirmButtonText: config.confirmButtonText || "OK",
        timer: config.timer || undefined,
        timerProgressBar: config.timer ? true : false,
        allowOutsideClick: config.allowOutsideClick !== false,
        showConfirmButton: config.showConfirmButton !== false,
        didClose: () => {
            // Cuando se cierra el cuadro de dialogo, procesar el siguiente mensaje
            setTimeout(() => {
                // Redireccionar si es necesario
                if (config.redirect) {
                    window.location.href = config.redirect;
                } else {
                    // Continua con el siguiente mensaje si no hay redireccion
                    processMessages(messages, index + 1);
                }
            }, 100);
        },
    };

    // Mostrar SweetAlert2
    Swal.fire(swalConfig);
}

/**
 * Muestra una notificación de éxito
 * @param {string} message Mensaje a mostrar
 * @param {string|null} redirect URL para redireccionar después
 * @param {Object} config Configuración adicional
 */
function showSuccessMessage(message, redirect = null, config = {}) {
    config.title = config.title || "¡Éxito!";
    config.icon = "success";
    config.redirect = redirect;

    Swal.fire({
        title: config.title,
        text: message,
        icon: config.icon,
        timer: config.timer || 2000,
        timerProgressBar: true,
        showConfirmButton: config.showConfirmButton !== false,
        didClose: () => {
            if (redirect) {
                window.location.href = redirect;
            }
        },
    });
}

/**
 * Muestra una notificación de error
 * @param {string} message Mensaje a mostrar
 * @param {string|null} redirect URL para redireccionar despues
 * @param {Object} config Config adicional
 */
function showErrorMessage(message, redirect = null, config = {}) {
    config.title = config.title || "¡Error!";
    config.icon = "error";
    config.redirect = redirect;

    Swal.fire({
        title: config.title,
        text: message,
        icon: config.icon,
        timer: config.timer || 3000,
        timerProgressBar: true,
        showConfirmButton: config.showConfirmButton !== false,
        didClose: () => {
            if (redirect) {
                window.location.href = redirect;
            }
        },
    });
}

/**
 * Muestra un dialogo de confirmación
 * @param {string} message Mensaje a mostrar
 * @param {Function} callback Función a ejecutar si se confirma
 * @param {Object} config Config adicional
 */
function showConfirmDialog(message, callback, config = {}) {
    Swal.fire({
        title: config.title || "¿Estás seguro?",
        text: message,
        icon: config.icon || "warning",
        showCancelButton: true,
        confirmButtonColor: config.confirmButtonColor || "#3085d6",
        cancelButtonColor: config.cancelButtonColor || "#d33",
        confirmButtonText: config.confirmButtonText || "Sí, continuar",
        cancelButtonText: config.cancelButtonText || "Cancelar",
    }).then((result) => {
        if (result.isConfirmed && typeof callback === "function") {
            callback();
        }
    });
}

// Adjuntar funciones al objeto window para uso global
window.showSuccessMessage = showSuccessMessage;
window.showErrorMessage = showErrorMessage;
window.showConfirmDialog = showConfirmDialog;
