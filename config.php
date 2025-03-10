<?php
// Configuración general
define('WORKSPACE_DIR', __DIR__ . '/workspace');
define('AI_API_KEY', 'your-api-key-here'); // Reemplazar con la clave real

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/error.log');

// Crear directorio de workspace si no existe
if (!file_exists(WORKSPACE_DIR)) {
    mkdir(WORKSPACE_DIR, 0777, true);
}

// Crear directorio de logs si no existe
if (!file_exists(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0777, true);
}
?>
