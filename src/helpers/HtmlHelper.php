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

    /**
     * Genera un modal de confirmación dinámico en HTML con Bootstrap.
     * 
     * Este método permite personalizar dinámicamente el contenido y los estilos
     * del modal, como el título, el cuerpo, los botones y sus clases CSS asociadas.
     * 
     * @param array $options Opciones de congiguración para el modal.
     * - 'id': (string) ID único del modal. Valor por defecto 'dynamicConfirmModal'.
     * - 'title': (string) Titulo del modal. Valor por defecto: traducción de 'DYNAMIC_MODAL_TITLE'.
     * - 'body': (string) Contenido del cuerpo del modal. Valor por defect: tradución de 'DYNAMIC_MODAL_MSG'.
     * - 'confirmText': (string) Texto del boton de confirmación. Valor por defecto: traducción de 'DYNAMIC_MODAL_YES_BUTTON'.
     * - 'cancelText': (string) Texto del boton de cancelación. Valor por defecto: traducción de 'DYNAMIC_MODAL_NO_BUTTON'.
     * - 'confirmClass': (string) Class CSS para el boton de confirmación. Valor por defecto: 'btn btn-primary'.
     * - 'cancelClass': (string) Class CSS para el boton de cancelación. Valor por defecto: 'btn btn-secondary'.
     * @return string Código HTML del modal.
     */
    public function htmlDynamicConfirmModal(array $options = []): string {
        // Obtener y sanitizar las opciones del modal
        $id = htmlspecialchars($options['id'] ?? 'dynamicConfirmModal', ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($options['title'] ?? $this->translator->trans('DYNAMIC_MODAL_TITLE'), ENT_QUOTES, 'UTF-8');
        $body = htmlspecialchars($options['body'] ?? $this->translator->trans('DYNAMIC_MODAL_MSG'), ENT_QUOTES, 'UTF-8');
        $confirmText = htmlspecialchars($options['confirmText'] ?? $this->translator->trans('DYNAMIC_MODAL_YES_BUTTON'), ENT_QUOTES, 'UTF-8');
        $cancelText = htmlspecialchars($options['cancelText'] ?? $this->translator->trans('DYNAMIC_MODAL_NO_BUTTON'), ENT_QUOTES, 'UTF-8');
        $confirmClass = htmlspecialchars($options['confirmClass']?? 'btn btn-primary', ENT_QUOTES, 'UTF-8');
        $cancelClass = htmlspecialchars($options['cancelClass']?? 'btn btn-secondary', ENT_QUOTES, 'UTF-8');

        // Generar y retornar el HTML del modal
        return sprintf(
            '<div 
                class="modal fade" 
                id="%s" 
                tabindex="-1" 
                aria-labelledby="%sLabel" 
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <!-- Header del Modal -->
                        <div class="modal-header bg-primary text-white">
                            <h5 
                                class="modal-title"
                                id="%sLabel"
                                style="color: white;"
                            >
                                %s
                            </h5>
                            <button 
                                type="button" 
                                class="btn-close" 
                                data-bs-dismiss="modal" 
                                aria-label="Close"
                            ></button>
                        </div>
                        <!-- Cuerpo del Modal -->
                        <div class="modal-body">
                            %s
                        </div>
                        <!-- Footer del Modal -->
                        <div class="modal-footer">
                            <button 
                                type="button" 
                                class="%s"
                                id="cancelBtn"
                                data-bs-dismiss="modal"
                            >
                                %s
                            </button>
                            <button 
                                type="button" 
                                class="$s" 
                                id="confirmBtn"
                            >
                                %s
                            </button>
                        </div>
                    </div>
                </div>
            </div>',
            $id,                // ID del modal
            $id,                // ID para el atributo labelledby
            $id,                // ID del titulo
            $title,             // Título del modal
            $body,              // Contenido del cuerpo del modal
            $cancelClass,       // Class CSS para el botón de cancelación
            $cancelText,        // Texto del botón de cancelación
            $confirmClass,      // Class CSS para el botón de confirmación
            $confirmText        // Texto del botón de confitmación
        );
    }

    /**
     * Determina la clase CSS del color según el estado de la tarea.
     * 
     * @param string $estado Nombre del estado de la tarea.
     * @return string Clase CSS asociada al estado.
     */
    public function getEstadoColorClass($estado): string {
        // Ajustar el estado al idioma actual
        $estadoAjustado = match (strtolower($estado)) {
            'activa', 'active' => $this->translator->trans('APP_TAREA_ESTADO_ACTIVA'),
            'pendiente', 'pending' => $this->translator->trans('APP_TAREA_ESTADO_PENDIENTE'),
            'finalizada', 'completed' => $this->translator->trans('APP_TAREA_ESTADO_FINALIZADA'),
            'en_marcha', 'in_progress' => $this->translator->trans('APP_TAREA_ESTADO_EN_MARCHA'),
            'cancelada', 'cancelled' => $this->translator->trans('APP_TAREA_ESTADO_CANCELADA'),
            'fallada', 'failed' => $this->translator->trans('APP_TAREA_ESTADO_FALLADA'),
            default => strtolower($estado),
        };

        return match ($estadoAjustado) {
            $this->translator->trans('APP_TAREA_ESTADO_ACTIVA') => "card-activa",
            $this->translator->trans('APP_TAREA_ESTADO_PENDIENTE') => "card-pendiente",
            $this->translator->trans('APP_TAREA_ESTADO_FINALIZADA') => "card-finalizada",
            $this->translator->trans('APP_TAREA_ESTADO_EN_MARCHA') => "card-en-marcha",
            $this->translator->trans('APP_TAREA_ESTADO_CANCELADA') => "card-cancelada",
            $this->translator->trans('APP_TAREA_ESTADO_FALLADA') => "card-fallada",
            default => "card-default",
        };
    }

    /**
     * Determina la clase CSS del badge según el estado de la tarea.
     * 
     * @param string $estado Nombre del estado de la tarea.
     * @return string Clase CSS asociada al badge.
     */
    public function getBadgeColorClass($estado): string {
        // Ajustar el estado al idioma actual
        $estadoAjustado = match (strtolower($estado)) {
            'activa', 'active' => $this->translator->trans('APP_TAREA_ESTADO_ACTIVA'),
            'pendiente', 'pending' => $this->translator->trans('APP_TAREA_ESTADO_PENDIENTE'),
            'finalizada', 'completed' => $this->translator->trans('APP_TAREA_ESTADO_FINALIZADA'),
            'en_marcha', 'in_progress' => $this->translator->trans('APP_TAREA_ESTADO_EN_MARCHA'),
            'cancelada', 'cancelled' => $this->translator->trans('APP_TAREA_ESTADO_CANCELADA'),
            'fallada', 'failed' => $this->translator->trans('APP_TAREA_ESTADO_FALLADA'),
            default => strtolower($estado),
        };

        return match (strtolower($estadoAjustado)) {
            $this->translator->trans('APP_TAREA_ESTADO_ACTIVA') => "bg-primary",                       // Azul
            $this->translator->trans('APP_TAREA_ESTADO_PENDIENTE') => "bg-warning text-dark",          // Amarillo
            $this->translator->trans('APP_TAREA_ESTADO_FINALIZADA') => "bg-success",                   // Verde
            $this->translator->trans('APP_TAREA_ESTADO_EN_MARCHA') => "bg-orange",                     // Naranja  (debes definir esta clase en CSS)
            $this->translator->trans('APP_TAREA_ESTADO_CANCELADA') => "bg-danger",                     // Rojo
            $this->translator->trans('APP_TAREA_ESTADO_FALLADA') => "bg-purple text-light",            // Púrpura (debes definir esta clase en CSS)
            default => "bg-secondary",
        };
    }

    /**
     * Determina la clase CSS del badg según el estado de la tarea
     * 
     * @param string $estado nombre del estado de la tarea
     * @return string Nombre del estado de la tarea< ajustado al idioma actual
     */
    public function ajustarEstadoToLocale ($estado): string {
        return match (strtolower($estado)) {
            'activa', 'active' => $this->translator->trans('APP_TAREA_ESTADO_ACTIVA'),
            'pendiente', 'pending' => $this->translator->trans('APP_TAREA_ESTADO_PENDIENTE'),
            'finalizada', 'completed' => $this->translator->trans('APP_TAREA_ESTADO_FINALIZADA'),
            'en_marcha', 'in_progress' => $this->translator->trans('APP_TAREA_ESTADO_EN_MARCHA'),
            'cancelada', 'cancelled' => $this->translator->trans('APP_TAREA_ESTADO_CANCELADA'),
            'fallada', 'failed' => $this->translator->trans('APP_TAREA_ESTADO_FALLADA'),
            default => strtolower($estado),
        };
    }
    
}