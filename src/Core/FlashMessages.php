<?php

namespace VetApp\Core;

/**
 * Clase para manejar mensajes flash entre peticiones usando sesiones
 */
class FlashMessages
{
    /**
     * Tipos de mensajes permitidos
     */
    public const SUCCESS = 'success';
    public const ERROR = 'error';
    public const WARNING = 'warning';
    public const INFO = 'info';

    /**
     * Configuraciones por defecto para cada tipo de alerta
     */
    private const DEFAULT_CONFIG = [
        self::SUCCESS => [
            'title' => '¡Éxito!',
            'icon' => 'success',
            'timer' => 2000,
            'redirect' => null
        ],
        self::ERROR => [
            'title' => '¡Error!',
            'icon' => 'error',
            'timer' => 3000,
            'redirect' => null
        ],
        self::WARNING => [
            'title' => '¡Advertencia!',
            'icon' => 'warning',
            'timer' => 3000,
            'redirect' => null
        ],
        self::INFO => [
            'title' => 'Información',
            'icon' => 'info',
            'timer' => 2000,
            'redirect' => null
        ]
    ];

    /**
     * Constructor que inicia la sesión si no está iniciada
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['flash_messages'])) {
            $_SESSION['flash_messages'] = [];
        }
    }

    /**
     * Establece un mensaje flash con configuración personalizable
     * 
     * @param string $type Tipo de mensaje (success, error, warning, info)
     * @param string $message Contenido del mensaje
     * @param array $config Configuracion adicional
     * @return void
     */
    public function set(string $type, string $message, array $config = [])
    {
        // Por defecto es INFO
        if (!isset(self::DEFAULT_CONFIG[$type])) {
            $type = self::INFO;
        }

        $_SESSION['flash_messages'][] = [
            'type' => $type,
            'message' => $message,
            'config' => array_merge(self::DEFAULT_CONFIG[$type], $config)
        ];
    }

    /**
     * Método abreviado para mensajes de exito
     * 
     * @param string $message Contenido del mensaje
     * @param string|null $redirect URL a redireccionar despues del mensaje
     * @param array $config Config adicional
     * @return void
     */
    public function success(string $message, ?string $redirect = null, array $config = [])
    {
        $config['redirect'] = $redirect;
        $this->set(self::SUCCESS, $message, $config);
    }

    /**
     * Método abreviado para mensajes de error
     * 
     * @param string $message Contenido del mensaje
     * @param string|null $redirect URL a redireccionar despues del mensaje
     * @param array $config Config adicional
     * @return void
     */
    public function error(string $message, ?string $redirect = null, array $config = [])
    {
        $config['redirect'] = $redirect;
        $this->set(self::ERROR, $message, $config);
    }

    /**
     * Método abreviado para mensajes de advertencia
     * 
     * @param string $message Contenido del mensaje
     * @param string|null $redirect URL a redireccionar después del mensaje
     * @param array $config Config adicional
     * @return void
     */
    public function warning(string $message, ?string $redirect = null, array $config = [])
    {
        $config['redirect'] = $redirect;
        $this->set(self::WARNING, $message, $config);
    }

    /**
     * Método abreviado para mensajes informativos
     * 
     * @param string $message Contenido del mensaje
     * @param string|null $redirect URL a redireccionar después del mensaje
     * @param array $config Config adicional
     * @return void
     */
    public function info(string $message, ?string $redirect = null, array $config = [])
    {
        $config['redirect'] = $redirect;
        $this->set(self::INFO, $message, $config);
    }

    /**
     * Obtiene todos los mensajes flash y los limpia de la sesión
     * 
     * @return array Mensajes flash almacenados
     */
    public function get()
    {
        $messages = $_SESSION['flash_messages'] ?? [];
        $_SESSION['flash_messages'] = [];
        return $messages;
    }

    /**
     * Verifica si hay mensajes flash almacenados
     * 
     * @return bool True si hay mensajes, false en caso contrario
     */
    public function has()
    {
        return !empty($_SESSION['flash_messages']);
    }

    /**
     * Genera el script JavaScript necesario para mostrar los mensajes flash
     * 
     * @return string Script JavaScript o cadena vacía si no hay mensajes
     */
    public function toJson()
    {
        $messages = $this->get();
        if (empty($messages)) {
            return '[]';
        }

        return json_encode($messages);
    }
}
