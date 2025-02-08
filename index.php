<?php
/**
 * Punto de entrada de la aplicación
 * 
 * Configura la carga de dependencias, inicializa variables de entorno y
 * define rutas clave del sistema.
 */

    // Utilizar Dotenv para manejar variables de entorno
    use Dotenv\Dotenv;
    use Hztpaing\Tareas\controller\Router;
    use Hztpaing\Tareas\src\localization\Translator;

    // Detectar el entorno actual
    $envFile = getenv('APP_ENV') ?: 'desarrollo';

    // Validar el entorno
    $validEnvs = ['desarrollo', 'produccion'];
    if (!in_array($envFile, $validEnvs)) {
        die("Entorno no válido: $envFile");
    }

    // Si no esta definido BASE_PATH cargamos __DIR__
    $basePath = defined('BASE_PATH') ? BASE_PATH : __DIR__;

    // Cargar el autoload de Composer
    require_once($basePath . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

    // Cargar el archivo.env según el entorno
    try {
        $dotenv = Dotenv::createImmutable($basePath, ".env.$envFile");
        $dotenv->load();
    } catch (Exception $e) {
        die(
            $translator->trans('ERR_ENV_NO_CARGA') . ': ' . $e->getMessage()
        );
    }

    // Iniciar sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Cargar configuración
    require_once('config.php');

    // Cargar el contenedor de dependencias
    require_once(BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'container.php');
    global $container;

    // Obtener el servicio 'translator' desde el contenedor
    $translator = $container['translator'];
    // Obtener el servicio 'HtmlHelper' desde el contenedor
    $htmlHelper = $container['htmlHelper'];

    $app = new Router();
?>