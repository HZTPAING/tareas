<?php

namespace Hztpaing\Tareas\src\helpers;

use Hztpaing\Tareas\src\localization\Translator;

/**
 * Clase HtmlHelper
 *
 * Proporciona métodos auxiliares para generar componentes HTML reutilizables.
 * de manera dinámica y segura.
 */

class HtmlHelper {
    /**
     * Instancia del servicio de traducción.
     *
     * @var Translator
     */
    private Translator $translator;
    
    /**
     * Constructor de la clase HtmlHelper.
     *
     */
    public function __construct() {
        global $container;
        $this->translator = $container['translator'];
    }

    /**
     * Genera un mensaje de alerta en HTML con Bootstrap.
     *
     * @param string $resCode Código del mensaje predefinido (clave de traducción).
     * @param string|null $resData Información adicional que se inserta dinámicamente en el mensaje.
     * @return string Código HTML del mensaje de alerta.
     * @throws \InvalidArgumentException Si el código de mensaje no existe.
     */
    public function htmlMessageZone(string $resCode, ?string $resData = null): string {
        // Obtener la configuración del mensaje desde las traducciones
        $mensajeConfig = $this->translator->trans($resCode);
        
        // Validar que el código de mensaje existe
        if (!isset($mensajeConfig['type']) || !isset($mensajeConfig['msg'])) {
            // Obtener el mensaje de error desde las traducciones
            $errorMessage = $this->translator->trans('ERR_CODE_NOT_DEFINED')
                ?? 'El código de mensaje \'%s\' no está definido en las traducciones.';

            throw new \InvalidArgumentException(
                sprintf($errorMessage, htmlspecialchars($resCode, ENT_QUOTES, 'UTF-8'))
            );
        }

        // Sanitizar y procesar el contenido dinámico del mensaje
        $messajeType = htmlspecialchars($mensajeConfig['type'], ENT_QUOTES, 'UTF-8');
        $mensajeContentent = sprintf(
            htmlspecialchars_decode($mensajeConfig['msg'], ENT_QUOTES),
            htmlspecialchars($resData ?? '', ENT_QUOTES, 'UTF-8')
        );
        
        // Generar el HTML del mensaje
        return sprintf(
            '<div class="alert alert-%s alert-dismissible fade show d-flex align-items-center" role="alert" style="width: 100%%;">
                <span style="flex-grow: 1;">%s</span>
                <button type="button" class="btn-close btn-alert-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>',
            $messajeType,
            $mensajeContentent
        );
    }
    
    /**
     * Genera un saludo dinámico en HTML para el usuario actual.
     * 
     * @param string $usuario Nombre del usuario logueado.
     * @return string Código HTML del saludo del usuario.
     */
    public function htmlSaludo(string $usuario): string {
        // Obtener el texto traducido para las etiquetas
        $tituloUsuario = htmlspecialchars($this->translator->trans('APP_USUARIO'), ENT_QUOTES, 'UTF-8');
        $notificaciones = htmlspecialchars($this->translator->trans('APP_NOTIFICACIONES'), ENT_QUOTES, 'UTF-8');

        // Generar el saludo en formato HTML
        return sprintf(
            '<div class="saludo-usuario">
                <!-- <h2 class="card-title text-primary">%s</h2> -->
                <p class="card-text">
                    <span class="me-2">%s:</span>
                    <span class="fw-bold text-info">%s</span>
                    <i class="fa-solid fa-bell ms-2" title="%s"></i>
                </p>
            </div>',
            $tituloUsuario,
            $tituloUsuario,
            htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8'),    // Nombre del usuario
            $notificaciones                                     // Tooltip para el icono de notificaciones
        );
    }
}