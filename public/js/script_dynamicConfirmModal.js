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
 * @param {Function} options.onConfirm Función a ejecutar al confirmar.
 * @param {Function} options.onCancel Función a ejecutar al cancelar (opcional).
 */
function showDynamicConfirmModal(options) {
    // Asegurar que las traducciones están cargadas
    if (Object.keys(translations).length === 0) {
        console.warn('Las traducciones aún no han sido cargadas');
        return;
    }

    // Obtener traducciones desde la variable global
    const title = options.title || translations.DYNAMIC_MODAL_TITLE;                        // "Confirmar acción"
    const body = options.body || translations.DYNAMIC_MODAL_MSG;                            // "¿Estás seguro de que deseas realizar esta acción?"
    const confirmText = options.confirmText || translations.DYNAMIC_MODAL_YES_BUTTON;       // "Confirmar"
    const cancelText = options.cancelText || translations.DYNAMIC_MODAL_NO_BUTTON;          // "Cancelar"

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
    modalTitle.textContent = title;

    // Establecer el estylo del body
    modalBody.ClassName = `modal-body ${options.confirmBodyClass || 'bg-light bg-gradient'}`;
    // Establecer el contenido del cuerpo del modal
    modalBody.innerHTML = body;

    // Establecer el estylo del footer
    modalFooter.className = `modal-footer ${options.confirmFooterClass || 'bg-light'}`;

    // Configurar botones
    confirmBtn.textContent = confirmText;
    confirmBtn.className = `btn ${options.confirmBtnClass || 'btn-primary'}`;
    cancelBtn.textContent = cancelText;
    cancelBtn.className = `btn ${options.cancelBtnClass || 'btn-secondary'}`;

    //Remover eventos previos para evitar duplicados
    const newConfirmBtn = confirmBtn.cloneNode(true);
    //confirmBtn.parentNode.removeChild(newConfirmBtn, confirmBtn);

    // Agregar eventos a los botones
    // Asignar el evento de confirmación
    newConfirmBtn.addEventListener('click', function() {
        if (options.onConfirm && typeof options.onConfirm === 'function') {
            options.onConfirm();  // Ejecutar la función de confirmación pasada por el usuario
        }
        // Ocultar el modal después de confirmar
        bootstrap.Modal.getInstance(modalElement).hide();
    });

    // Asignar el evento de cancelación
    if (options.onCancel && options.onCancel === 'function') {
        cancelBtn.addEventListener('click', function (){
            options.onCancel();  // Ejecutar la función de cancelación pasada por el usuario
        });
    }

    // Mostrar el modal
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}