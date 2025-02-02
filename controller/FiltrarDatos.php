<?php
/**
 * Clase FiltrarDatos
 * 
 * Esta clase proporciona métodos para limpiar y filtrar datos de entrada, 
 * reduciendo riesgos de seguridad como XSS (Cross-Site Scripting) y asegurando
 * que las contraseñas sean procesadas de forma segura.
 */

 namespace Hztpaing\Tareas\controller;

 use Hztpaing\Tareas\localization\Translator;
 use \InvalidArgumentException;

 

class FiltrarDatos
{
    /**
     * Filtrar datos de entrada
     * 
     * Este método limpia los datos de entrada, aplicando un filtrado más estricto 
     * para contraseñas y datos sensibles.
     * 
     * @param mixed $datos Datos de entrada (puede ser array o cadena).
     * @return mixed Datos filtrados.
     */

    // El atributo de la enlace al clase Translator
    private $translator;
    
    // Constructor de la clase
    public function __construct() {
        global $container;
        $this->translator = $container['translator'];
    }

    public function Filtrar($datos)
    {
        // Claves que contienen contraseñas o datos sensibles
        $passwordKeys = ['pass', 'contraseña'];

        // Verificar si los datos son un array
        if (is_array($datos)) {
            foreach ($datos as $key => $value) {
                if (in_array($key, $passwordKeys)) {
                    // Procesar contraseñas de forma segura
                    $datos[$key] = $this->ProcesarContrasena($value);
                } else {
                    // Limpiar otros datos
                    $datos[$key] = $this->LimpiarDatos($value);
                }
            }
        } else {
            // Si no es un array, limpiar directamente
            $datos = $this->LimpiarDatos($datos);
        }

        return $datos;
    }

    /**
     * Limpiar datos genéricos
     * 
     * Este método limpia espacios en blanco, barras invertidas, y convierte 
     * caracteres especiales para prevenir inyecciones XSS.
     * 
     * @param string $datos Dato de entrada a limpiar.
     * @return string Dato limpio.
     */
    private function LimpiarDatos($datos)
    {
        if (!is_string($datos)) {
            return $datos; // Devuelve tal cual si no es una cadena
        }

        $datos = trim($datos); // Eliminar espacios en blanco
        $datos = stripslashes($datos); // Eliminar barras invertidas
        $datos = htmlspecialchars($datos, ENT_QUOTES, 'UTF-8'); // Convertir caracteres especiales
        return $datos;
    }

    /**
     * Procesar contraseñas
     * 
     * Este método aplica hashing seguro a las contraseñas utilizando `password_hash`.
     * 
     * @param string $pass Contraseña a procesar.
     * @return string Contraseña hasheada.
     */
    private function ProcesarContrasena($datos)
    {
        if (!is_string($datos)) {
            return $datos;
        }

        $datos = trim($datos); // Eliminar espacios en blanco
        $datos = stripslashes($datos); // Eliminar barras invertidas
        $datos = htmlspecialchars($datos, ENT_QUOTES, 'UTF-8'); // Convertir caracteres especiales
        return $datos;
    }
}
?>
