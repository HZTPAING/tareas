<?php
/**
 * Clase Autoload
 * 
 * Esta clase implementa un cargador automático de clases que busca y carga
 * los archivos correspondientes a los nombres de las clases en los directorios
 * específicos del proyecto. Esto elimina la necesidad de incluir manualmente
 * los archivos de clases.
 */
class Autoload
{
    /**
     * Constructor de la clase Autoload
     * 
     * Registra una función de autoload personalizada mediante `spl_autoload_register`.
     */
    public function __construct()
    {
        spl_autoload_register(function ($class_name) {
            // Directorios donde buscar clases
            $directories = [
                BASE_PATH . DIRECTORY_SEPARATOR . 'model',
                BASE_PATH . DIRECTORY_SEPARATOR . 'controller',
                BASE_PATH . DIRECTORY_SEPARATOR . 'src'
            ];

            // Recorremos los directorios indicados y cargamos las clases
            foreach ($directories as $directory) {
                $file = $directory . DIRECTORY_SEPARATOR . $class_name . '.php';
                if (file_exists($file)) {
                    require_once($file);
                    return;     // Detener la búsqueda si se encuentra la clase
                }
            }
        });
    }
}
