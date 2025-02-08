<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Definir la ruta base del proyecto
    define('BASE_PATH', __DIR__);

    // Definir la ruta base de la carpeta principal de las vistas
    define('BASE_PATH_VIEWS', BASE_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

    // Configuración de la base de datos
    define('DB_CHARSET', 'utf8');

    // Cargar la variabla APP_LOCATE desde desde la variabla de session o desde .env
    $locale = $_SESSION['locale'] ?? $_ENV['APP_LOCALE'] ?? getenv('APP_LOCALE') ?? 'es';
    // Configuración deL IDIOMA DEL INTERFACE por defecto
    define('APP_LOCALE', $locale);
    
    // Definir las variables cargadas desde .env
    define('BASE_URL', $_ENV['BASE_URL']);
    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASS', $_ENV['DB_PASSWORD']);
    define('DB_NAME', $_ENV['DB_NAME']);

?>