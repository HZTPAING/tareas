<?php

namespace Hztpaing\Tareas\src\helpers;

use Hztpaing\Tareas\src\localization\Translator;

/**
 * Clase ModalHelper
 * 
 * Genera formularios modales dinámicos y realizables con Bootstrap
 * Soporta traducciones, personalización de estilos y eventos dinamicos
 */
class ModalHelper {
    /**
     * Instancia del servicio de traducción.
     *
     * @var Translator
     */
    private Translator $translator;

    /**
     * Instancia del servicio de htmlHelper - funciones auxiliares
     * 
     * @var HtmlHelper
     */
    private HtmlHelper $htmlHelper;
    
    /**
     * Constructor de la clase ModalHelper.
     *
     * Obtiene la instancia del servicio de traducción desde el contenedor global
     */
    public function __construct() {
        global $container;
        $this->translator = $container['translator'];
        $this->htmlHelper = $container['htmlHelper'];               // Inyectamos la clase auxiliar HTML
    }

    /**
     * Genera un modal Bootstrap con contenido dinamico.
     * 
     * @param array $options Configuración del modal:
     * - 'id': (string) ID único del modal (por defecto: 'dynamicModal').
     * - 'title': (string) Titulo del modal (por defecto: traducción de 'DYNAMIC_MODAL_TITLE'.
     * - 'body': (string) Contenido HTML del cuerpo del modal. Valor por defect: tradución de 'DYNAMIC_MODAL_MSG'.
     * - 'action': (string) Nombre del evento JS o función para el boton de acción (opcional).
     * - 'width': (string) Ancho del modal en px o %, por defecto "600px".
     * - 'confirmText': (string) Texto del boton de confirmar (por defecto: traducción de 'DYNAMIC_MODAL_YES_BUTTON').
     * - 'cancelText': (string) Texto del boton de cancelar (por defecto: traducción de 'DYNAMIC_MODAL_NO_BUTTON').
     * - 'confirmClass': (string) Class CSS del boton de confirmar (por defecto: 'btn btn-success').
     * - 'cancelClass': (string) Class CSS para el boton de cancelar (por defecto: 'btn btn-secondary').
     * - 'estadoEstilo': (string|null) Nombre del estado de la tarea (opcional, afecta estilos dinamicamente)
     * @return string Código HTML del modal.
     */
    public function htmlDynamicModal(array $options = []): string {
        // Definir opciones predeterminadas y sanitizar las las valores recibidos
        $id = htmlspecialchars($options['id'] ?? 'dynamicModal', ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($options['title'] ?? $this->translator->trans('DYNAMIC_MODAL_TITLE'), ENT_QUOTES, 'UTF-8');
        $body = $options['body'] ?? ''; // Permite contenido HTML sin sanitizar para estructura flexible
        $action = htmlspecialchars($options['action'] ?? '', ENT_QUOTES, 'UTF-8');
        $width = htmlspecialchars($options['width'] ?? '600px', ENT_QUOTES, 'UTF-8');
        $headerColorTitle = htmlspecialchars($options['headerColorTitle'] ?? 'white', ENT_QUOTES, 'UTF-8');
        $confirmText = htmlspecialchars($options['confirmText'] ?? $this->translator->trans('DYNAMIC_MODAL_YES_BUTTON'), ENT_QUOTES, 'UTF-8');
        $cancelText = htmlspecialchars($options['cancelText'] ?? $this->translator->trans('DYNAMIC_MODAL_NO_BUTTON'), ENT_QUOTES, 'UTF-8');
        $confirmClass = htmlspecialchars($options['confirmClass']?? 'btn btn-primary', ENT_QUOTES, 'UTF-8');
        $cancelClass = htmlspecialchars($options['cancelClass']?? 'btn btn-secondary', ENT_QUOTES, 'UTF-8');

        // Determinar el estilo del Modal basando en el estado (opcional)
        $estadoEstilo = $options['estadoEstilo'] ?? null;
        $headerClass = 'bg-primary text-white';
        $footerClass = 'bg-light';

        if ($estadoEstilo) {
            $headerClass = $this->htmlHelper->getBadgeColorClass($estadoEstilo);
            $footerClass = str_replace('bg-', 'footer-bg-', $headerClass);              // Adaptamos para el footer si necesario
            $headerColorTitle = 'dark';
        }

        // Generar y retornar el HTML del modal
        return sprintf(
            '<div 
                class="modal fade" 
                id="%s" 
                tabindex="-1" 
                aria-labelledby="%sLabel" 
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered" style="max-width: %s;">
                    <div class="modal-content">
                        <!-- Header del Modal -->
                        <div class="modal-header %s">
                            <h5 
                                class="modal-title"
                                id="%sLabel"
                                style="color: %s;"
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
                        <div class="modal-footer %s">
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
                                onclick="%s"
                            >
                                %s
                            </button>
                        </div>
                    </div>
                </div>
            </div>',
            $id,                // ID del modal
            $id,                // ID para el atributo labelledby
            $width,             // Ancho del modal
            $headerClass,       // Class CSS para el header del modal
            $id,                // ID del titulo
            $headerColorTitle,  // Color de título del modal
            $title,             // Título del modal
            $body,              // Contenido dinámico del cuerpo del modal
            $footerClass,       // Class CSS dínamicas para el footer del modal
            $cancelClass,       // Class CSS para el botón de cancelación
            $cancelText,        // Texto del botón de cancelación
            $confirmClass,      // Class CSS para el botón de confirmación
            $action,            // Acción JS o función para el botón de confirmación
            $confirmText        // Texto del botón de confitmación
        );
    }
}