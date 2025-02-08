/**
 * Script para gestionar la interacción con las tareas
 * 
 * - Usa la API Fetch para eliminar tareas mediante solicitudes AJAX al backend.
 * - Utiliza traducciones dinamicas desde `translations` cargado en `script_translations.js`
 * - Emplea `showDynamicConfirmModal()` para mostrar confirmaciones antes de implementar la acción
 */

document.addEventListener('DOMContentLoaded', function() {
    // alert('sdfsdfs123133');
})

// Esperar a que las traducciones se cargan antes de ejecutar acciones
document.addEventListener('DOMContentLoaded', async () => {
    await loadTranslations();
});

/**
 * Function para manejar la eliminación de una tarea con confirmación
 * 
 * @param {Event} event - evento del click en el botón de eliminar.
 */
function eliminarTarea(event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del enlace o boton

    // Referencia al contenedor de los mensajes
    const mensajeStatus = document.getElementById('mensajeStatus');
    
    // Obtener datos de la tarea
    const botonEliminar = event.target;
    const rowId = botonEliminar.dataset.rowid;
    const nombreTarea = botonEliminar.dataset.nombre;

    // Mostrar el modal de confirmación antes de eliminar 
    showDynamicConfirmModal({
        title: translations.DYNAMIC_MODAL_BORRAR_TAREA_TITLE || 'Confirmación de eliminar tarea',
        body: `${translations.DYNAMIC_MODAL_BORRAR_TAREA_MSG || "¿Estás seguro de que deseas eliminar tarea:"}
            <br><snap style="color: blue;">"${nombreTarea}"</snap><br>
            ${translations.DYNAMIC_MODAL_BORRAR_TAREA_WARNING || "Esta acción no se puede deshacer."}`,
        confirmText: translations.DYNAMIC_MODAL_BORRAR_TAREA_YES_BUTTON || 'Borrar',
        cancelText: translations.DYNAMIC_MODAL_BORRAR_TAREA_NO_BUTTON || 'Cancelar',
        confirmBtnClass: 'btn btn-danger',
        cancelBtnClass: 'btn btn-secondary',
        confirmHeaderClass: 'bg-danger',
        confirmBodyClass: 'bg-light',
        confirmFooterClass: 'bg-light',

        onConfirm: function() {
            // Solicitud AJAX para elimenar la tarea
            fetch(`${API_BASE_URL}index.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    'views': 'tareas',
                    'action': 'AJAX_ELIMINAR_TAREA',
                    'rowId': rowId,                               // La clave de la tarea
                    'numero': nombreTarea                         // El nombre de la tarea
                })
            })
            .then(response => response.json())      // Convertir respuesta a JSON
            .then(data => {
                alert("Tareas: " + JSON.stringify(data));
                if (data.success) {
                    // Cerrar modal después de la confirmación
                    const modalInstance = bootstrap.Modal.getInstance(
                        document.getElementById('dynamicConfirmModal')
                    );
                    if (modalInstance) modalInstance.hide();

                    // Buscar y elimenar la tarjeta de la tarea en el DOM
                    const tareaCard = document.querySelector(`[data-rowid="${rowId}"]`)?.closest('.tarea-card');
                    if (tareaCard) tareaCard.remove();

                    // Mostrar mensaje de éxito si se borró correctamente
                    mensajeStatus.innerHTML = htmlMessageZone(
                        translations.BORRAR_TAREA_EXITO || `La tarea ${data.msg} ha sido eliminada correctamente.`, 
                        data.msg 
                    );
                } else {
                    // Mostrar mensaje de error si no se pudo borra la tarea
                    mensajeStatus.innerHTML = htmlMessageZone(
                        translations.BORRAR_TAREA_ERROR || `Error al intentar eliminar la tarea ${data.msg}.`, 
                        data.msg 
                    );
                }
            })
            .catch(error => {
                // Mostrar mensaje de error si no se pudo completar la solicitud AJAX
                    mensajeStatus.innerHTML = htmlMessageZone(
                        translations.BORRAR_TAREA_FAIL || `Error al procesar solicitud AJAX.`, 
                        data.msg 
                    );
            });
            // El final de la solicitud Fetch API al backend (controller.php)
        }
    });
}