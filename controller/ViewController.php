<?php

    namespace Hztpaing\Tareas\controller;

    use Hztpaing\Tareas\src\localization\Translator;
    use InvalidArgumentException;

/**
 * Clase ViewController
 * 
 * Gestiona la carga de vistas y plantillas en la aplicación,
 * asegurando la correcta inclusión de archivos y manejo de solicitudes AJAX.
 */
class ViewController {
    /**
     * Ruta base donde se almacenan las vistas.
     *
     * @var string
     */
    private string $view_path;

    /**
     * Servicio de traducción.
     *
     * @var Translator
     */
    private Translator $translator;

    /**
     * Constructor de la clase ViewController.
     *
     * @param string $viewPath Ruta absoluta al directorio de vistas.
     * @param Translator $translator Servicio de traducción para manejar mensajes.
     * @throws InvalidArgumentException Si la ruta proporcionada no es un directorio válido.
     */
    public function __construct(string $viewPath) {
        global $container;

        $this->translator = $container['translator'];

        if (!is_dir($viewPath)) {
            throw new InvalidArgumentException(
                $this->translator->trans('ERR_RUTA_VISTAS_NO_VALIDA') . ": $viewPath"
            );
        }
        // Asegura que la ruta termine con un separador de directorio
        $this->view_path = rtrim($viewPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * Carga una vista específica junto con las plantillas de encabezado y pie de página.
     *
     * @param string $view Nombre de la vista a cargar (sin extensión).
     * @throws InvalidArgumentException Si la vista especificada no existe.
     */
    public function load_view(string $view, array $data = []): void
    {
        $viewFile = $this->view_path . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new InvalidArgumentException(
                $this->translator->trans('ERR_VISTA_NO_EXISTE') . ": $view"
            );
        }
        
        // Extraer las variables del array $data para que estén disponibles como variables locales en la vista
        extract($data); // Extrae las variables pasadas como parámetros al método en variables locales

        // Si la solicitud es AJAX, incluye la vista en lugar de mostrar el contenido
        if ($this->is_ajax_request()) {
            // Para solicitudes AJAX, solo se carga la vista solicitada
            require_once($viewFile);
        } else {
            // Para solicitudes normales, se incluyen las plantillas de encabezado y pie de página
            $this->load_template('header');
            require_once($viewFile);
            $this->load_template('footer');
        }
    }

    /**
     * Verifica si la solicitud actual es una petición AJAX.
     *
     * @return bool Verdadero si es una solicitud AJAX, falso en caso contrario.
     */
    public static function is_ajax_request(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Carga una plantilla específica (por ejemplo, 'header' o 'footer').
     *
     * @param string $template Nombre de la plantilla a cargar (sin extensión).
     * @throws InvalidArgumentException Si la plantilla especificada no existe.
     */
    public function load_template(string $template): void
    {
        $templateFile = $this->view_path . $template . '.php';

        if (!file_exists($templateFile)) {
            throw new InvalidArgumentException(
                $this->translator->trans('ERR_PLANTILLA_NO_EXISTE') . ": $template"
            );
        }
        require_once($templateFile);
    }
}
?>