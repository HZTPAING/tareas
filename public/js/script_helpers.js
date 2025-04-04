import SelectElementJS from './SelectElementJS.js';
export { SelectElementJS };


/*
import { editarTarea } from './script_tareas.js';
window.editarTarea = editarTarea;
*/

/**
 * Funcion para generar un mensaje de alerta en HTML con Bootstrap.
 * 
 * @param {String} messageData - Datos del mensaje, que incluyen el mensaje y el tipo.
 * @param {String} resData - Información adicional que se inserta dinamicamente en el mensaje.
 * @return {String} - Código HTML de la alerta.
 */
export function htmlMessageZone(messageData, resData) {
    // Validar que los datos del mensaje existen y son válidos
    if (!messageData || typeof messageData !== 'object' || !messageData.msg || !messageData.type) {
        console.error(`Datos de mensaje no válidos: ${JSON.stringify(messageData)}`);
        return `
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert" style="width: 100%">
                <span style="flex-grow: 1;">Se produjo un error al generar el mensaje.</span>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }

    // Validar el tipo de la alerta
    const validTypes = ['success', 'danger', 'warning', 'info'];
    if (!validTypes.includes(messageData.type)) {
        console.warn(`Tipo de alerta inválido: "${messageData.type}". Se utilizará "info" por defecto.`);
        messageData.type = 'info';
    }

    // Sanitizar y procesar el contenido dinámico del mensaje
    const mensajeContent = messageData.msg.replace('%s', resData);

    // Generar y retornar el HTML de la alerta
    return `
        <div class="alert alert-${messageData.type} alert-dismissible fade show d-flex align-items-center" role="alert" style="width: 100%">
            <span style="flex-grow: 1;">${mensajeContent}</span>
            <button type="button" class="btn-close btn-alert-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
}

/**
 * Función para configurar y mostrar un modal dinámico de confirmación.
 * 
 * Este modal permite configurar dinámicamente el título, cuerpo, botones y estilos. 
 * Utiliza Bootstrap para la funcionalidad del modal y es compatible con traducciones
 * a través de un diccionario.
 * 
 * @param {Object} options Opciones para personalizar el modal.
 * @param {string} options.title Título del modal.
 * @param {string} options.body Contenido del cuerpo del modal.
 * @param {string} options.confirmText Texto del botón de confirmar.
 * @param {string} options.cancelText Texto del botón de cancelar.
 * @param {string} options.confirmHeaderClass Clase CSS para el encabezado del modal.
 * @param {string} options.confirmBodyClass Clase CSS para el cuerpo del modal.
 * @param {string} options.confirmFooterClass Clase CSS para el pie del modal.
 * @param {string} options.confirmBtnClass Clase CSS para el botón de confirmar.
 * @param {string} options.cancelBtnClass Clase CSS para el botón de cancelar.
 * @param {string} options.headerClass - Clase CSS para el encabezado del modal.
 * @param {string} options.footerClass - Clase CSS para el pie del modal.
 * @param {Function} options.onConfirm Función a ejecutar al confirmar.
 * @param {Function} options.onCancel Función a ejecutar al cancelar (opcional).
 */
export function showDynamicConfirmModal(options) {
    if (!options || typeof options !== 'object') {
        console.error('Error: Opciones inválidas para showDynamicConfirmModal.');
        return;
    }

    // Asegurar que las traducciones están cargadas
    if (Object.keys(translations).length === 0) {
        console.warn('Las traducciones aún no han sido cargadas');
        return;
    }

    // Obtener elementos del modal
    const modalElement = document.getElementById('dynamicConfirmModal');
    if (!modalElement) {
        console.error('No se encontró el modal con ID "dynamicConfirmModal".');
        return;
    }

    const modalHeader = modalElement.querySelector('.modal-header');
    const modalTitle = modalElement.querySelector('#dynamicConfirmModalLabel')
    const modalBody = modalElement.querySelector('.modal-body');
    const confirmBtn = modalElement.querySelector('#confirmBtn');
    const cancelBtn = modalElement.querySelector('#cancelBtn');
    const modalFooter = modalElement.querySelector('.modal-footer');
    
    // Configurar elementos del modal
    // Establecer el estilo del header
    modalHeader.className = `modal-header ${options.confirmHeaderClass || 'bg-danger bg-gradient'}`;

    // Establecer el título del modal
    modalTitle.textContent = options.title || translations.DYNAMIC_MODAL_TITLE;                        // "Confirmar acción"

    // Establecer el estylo del body
    modalBody.ClassName = `modal-body ${options.confirmBodyClass || 'bg-light bg-gradient'}`;
    // Establecer el contenido del cuerpo del modal
    modalBody.innerHTML = options.body || translations.DYNAMIC_MODAL_MSG;                            // "¿Estás seguro de que deseas realizar esta acción?"

    // Establecer el estylo del footer
    modalFooter.className = `modal-footer ${options.confirmFooterClass || 'bg-light'}`;

    // Configurar botones
    confirmBtn.textContent = options.confirmText || translations.DYNAMIC_MODAL_YES_BUTTON;       // "Confirmar"
    confirmBtn.className = `btn ${options.confirmBtnClass || 'btn-danger'}`;
    cancelBtn.textContent = options.cancelText || translations.DYNAMIC_MODAL_NO_BUTTON;          // "Cancelar"
    cancelBtn.className = `btn ${options.cancelBtnClass || 'btn-secondary'}`;

    // Reemplazar eventos previos del botón Confirmar
    confirmBtn.replaceWith(confirmBtn.cloneNode(true));
    const newConfirmBtn = modalElement.querySelector('#confirmBtn');
    // Asignar el evento de confirmación
    newConfirmBtn.addEventListener('click', function() {
        if (options.onConfirm && typeof options.onConfirm === 'function') {
            options.onConfirm();  // Ejecutar la función de confirmación
        }
        // Ocultar el modal después de confirmar
        bootstrap.Modal.getInstance(modalElement).hide();
    });

    // Reemplazar eventos previos del botón Confirmar
    cancelBtn.replaceWith(cancelBtn.cloneNode(true));
    const newCancelBtn = modalElement.querySelector('#cancelBtn');
    // Asignar el evento de cancelación
    newCancelBtn.addEventListener('click', function() {
        if (options.onCancel && typeof options.onCancel === 'function') {
            options.onCancel();  // Ejecutar la función de cancelación
        }
        // Ocultar el modal después de cancelar
        bootstrap.Modal.getInstance(modalElement).hide();
    });

    // Mostrar el modal
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

/**
 * Función para configurar y mostrar un modal dinámico de edición.
 * 
 * Este modal permite configurar dinámicamente el título, contenido del formulario,
 * y los botones de acción. Se utiliza Bootstrap para la funcionalidad del modal.
 * También es compatible con traducciones a través de un diccionario.
 *
 * @param {Object} options - Opciones para personalizar el modal.
 * @param {string} options.title - Título del modal.
 * @param {string} options.body - Contenido HTML que se insertará en el cuerpo del modal.
 * @param {string} options.confirmText - Texto del botón de confirmación.
 * @param {string} options.cancelText - Texto del botón de cancelación.
 * @param {string} options.confirmBtnClass - Clase CSS para el botón de confirmar.
 * @param {string} options.cancelBtnClass - Clase CSS para el botón de cancelar.
 * @param {string} [options.estadoEstilo] Estado actual de la tarea para aplicar estilos dinámicos (opcional)
 * @param {Function} options.onConfirm - Función a ejecutar cuando se confirma la acción.
 * @param {Function} [options.onCancel] - Función opcional a ejecutar cuando se cancela la acción.
 */
export function showDynamicEditModal(options) {
    // Validar las opciones
    if (!options || typeof options !== 'object') {
        console.error('Error: Opciones inválidas para showDynamicConfirmModal.');
        return;
    }
    
    // Obtener referencia al modal por su ID
    const modalElement = document.getElementById('dynamicEditModal');

    // Verificar si el modal existe en el DOM
    if (!modalElement) {
        console.error('No se encontró el modal con ID "dynamicEditModal".');
        return;
    }

    // Obtener los elementos internos del modal
    const modalHeader = modalElement.querySelector('.modal-header');
    const modalTitle = modalElement.querySelector('.modal-title');
    const modalBody = modalElement.querySelector('.modal-body');
    const modalFooter = modalElement.querySelector('.modal-footer');
    const confirmBtn = modalElement.querySelector('#confirmBtn');
    const cancelBtn = modalElement.querySelector('#cancelBtn');

    // Configurar el título del modal
    modalTitle.textContent = options.title || translations.DYNAMIC_MODAL_EDITAR_TAREA_TITLE || 'Editar Tarea';

    // Definir estilos dinámicos basados en el estado de la tarea (si se proporciona)
    const estadoEstilo = options.estadoEstilo || null;
    let headerClass = 'bg-primary text-white';
    let footerClass = 'bg-light';
    let bodyClass = 'bg-light';

    if (estadoEstilo) {
        switch (estadoEstilo.toLowerCase()) {
            case translations.APP_TAREA_ESTADO_ACTIVA:
                headerClass = 'card-activa card-activa-header';
                footerClass = 'card-activa card-activa-footer';
                bodyClass = 'card-activa';
                break;
            case translations.APP_TAREA_ESTADO_PENDIENTE:
                headerClass = 'card-pendiente card-pendiente-header';
                footerClass = 'card-pendiente card-pendiente-footer';
                bodyClass = 'card-pendiente';
                break;
            case translations.APP_TAREA_ESTADO_FINALIZADA:
                headerClass = 'card-finalizada card-finalizada-header';
                footerClass = 'card-finalizada card-finalizada-footer';
                bodyClass = 'card-finalizada';
                break;
            case translations.APP_TAREA_ESTADO_EN_MARCHA:
                headerClass = 'card-en-marcha card-en-marcha-header';
                footerClass = 'card-en-marcha card-en-marcha-footer';
                bodyClass = 'card-en-marcha';
                break;
            case translations.APP_TAREA_ESTADO_CANCELADA:
                headerClass = 'card-cancelada card-cancelada-header';
                footerClass = 'card-cancelada card-cancelada-footer';
                bodyClass = 'card-cancelada';
                break;
            case translations.APP_TAREA_ESTADO_FALLADA:
                headerClass = 'card-fallada card-fallada-header';
                footerClass = 'card-fallada card-fallada-footer';
                bodyClass = 'card-fallada';
                break;
            default:
                headerClass = 'bg-primary text-white';
                footerClass = 'bg-light';
                break;
        }
    }

    // Aplicar clases CSS personalizadas (o valores por defecto) al encabezado, cuerpo y pie del modal
    modalHeader.className = `modal-header ${headerClass}`;
    modalBody.className = `modal-body ${bodyClass || 'bg-light'}`;
    modalFooter.className = `modal-footer ${footerClass}`;

    // Insertar el contenido del cuerpo del modal (se espera un formulario o campos de edición)
    modalBody.innerHTML = options.body || '';

    // Configurar los botones del modal
    confirmBtn.textContent = options.confirmText || translations.DYNAMIC_MODAL_EDITAR_TAREA_YES_BUTTON || 'Guardar';
    confirmBtn.className = `btn ${options.confirmBtnClass || 'btn-success'}`;

    cancelBtn.textContent = options.cancelText || translations.DYNAMIC_MODAL_EDITAR_TAREA_NO_BUTTON || 'Cancelar';
    cancelBtn.className = `btn ${options.cancelBtnClass || 'btn-secondary'}`;

    // Reemplazar eventos previos del botón Confirmar para evitar duplicaciones
    confirmBtn.replaceWith(confirmBtn.cloneNode(true));
    const newConfirmBtn = modalElement.querySelector('#confirmBtn');

    // Agregar evento de confirmación al nuevo botón
    newConfirmBtn.addEventListener('click', function () {
        if (options.onConfirm && typeof options.onConfirm === 'function') {
            options.onConfirm(); // Ejecutar la función de confirmación proporcionada por el usuario
        }
        // Cerrar el modal después de confirmar
        bootstrap.Modal.getInstance(modalElement).hide();
    });

    // Reemplazar eventos previos del botón Cancelar
    cancelBtn.replaceWith(cancelBtn.cloneNode(true));
    const newCancelBtn = modalElement.querySelector('#cancelBtn');

    // Agregar evento de cancelación al nuevo botón (si se proporciona)
    newCancelBtn.addEventListener('click', function () {
        if (options.onCancel && typeof options.onCancel === 'function') {
            options.onCancel(); // Ejecutar la función de cancelación proporcionada por el usuario
        }
        // Cerrar el modal al cancelar
        bootstrap.Modal.getInstance(modalElement).hide();
    });

    // Crear una instancia de Bootstrap Modal y mostrarlo
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

/**
 * Función para generar el <select> con los datos proporcionados usando SelectElementJS
 * @param {string} id - ID del <select>
 * @param {string} name - Nombre del <select
 * @param {string} className - Clases CSS para el <select>
 * @param {boolean} required - Si es obligatorio
 * @param {boolean} multiple - Si permite selecciónar múltiple
 * @param {Array} options - Opciones del <select>
 * @param {boolean} showIcon - Muestra un icono externo con el estado actual
 * @returns {string} HTML generado del <select>
 */
export function renderSelectFilter(id, name, className, required, multiple, options, showIcon) {
    // Crear una nueva instancia de SelectElementJS
    const selectElement = new SelectElementJS(id, name, className, required, multiple, showIcon);

    // Establecer la opción por defecto
    selectElement.setDefaultOption('Seleccionar...', 'default');


    // Añadir las opciones al <select> usando el método addOption
    options.forEach(option => {
        selectElement.addOption(option.rowid, option.name, option.is_selected, option.iconClass || null);
    });

    // Renderizar el <select> y adjuntar evento de cambio si usa icono externo
    const selectHTML = selectElement.render();
    if (showIcon) selectElement.attachChangeEvent();

    return selectHTML;
}