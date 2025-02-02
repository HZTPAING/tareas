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

    // Cargar configuración
    require_once('config.php');

    // Cargar el autoload de Composer
    require_once(BASE_PATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

    // Cargar el contenedor de dependencias
    require_once(BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'container.php');
    global $container;
    // Obtener el servicio 'translator' desde el contenedor
    $translator = $container['translator'];
    // Obtener el servicio 'HtmlHelper' desde el contenedor
    $htmlHelper = $container['htmlHelper'];

    // Detectar el entorno actual
    $envFile = getenv('APP_ENV') ?: 'desarrollo';

    // Validar el entorno
    $validEnvs = ['desarrollo', 'produccion'];
    if (!in_array($envFile, $validEnvs)) {
        die("Entorno no válido: $envFile");
    }

    // Cargar el archivo.env según el entorno
    try {
        $dotenv = Dotenv::createImmutable(BASE_PATH, ".env.$envFile");
        $dotenv->load();
    } catch (Exception $e) {
        die(
            $translator->trans('ERR_ENV_NO_CARGA') . ': ' . $e->getMessage()
        );
    }

    // Definir las variables cargadas desde .env
    define('BASE_URL', $_ENV['BASE_URL']);
    // Definir las variables de acceso a la BD
    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASS', $_ENV['DB_PASSWORD']);
    define('DB_NAME', $_ENV['DB_NAME']);

    // Iniciar la carga automática de clases personalizadas
    // require_once(BASE_PATH . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . 'Autoload.php');
    // $autoload = new Autoload();

    $app = new Router();
?>