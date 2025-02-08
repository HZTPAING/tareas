<?php

// Iniciar sesión para obtener el idioma almacenado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar configuracion y contenedor
require_once(BASE_PATH . DIRECTORY_SEPARATOR . 'config.php');
require_once(BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'container.php');

// Obtener el idioma actual desde la sesión (o usar el predeterminado)
$locale = APP_LOCALE;

// Definir la ruta del archivo de traducciones
 $translationFile = BASE_PATH . DIRECTORY_SEPARATOR . 'locales' . DIRECTORY_SEPARATOR . $locale . 'messages.php';

 // Cargar traducciones si el archivo existe
 if (file_exists($translationFile)) {
    $translations = include $translationFile;
} else {
    $translations = ['error' => 'Archivo de traducción no encontrado'];
}

// Enviar la respuesta JSON
header('Content-Type: application/json');
echo json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

exit();
