/**
 * Script para gestionar la interacción con las tareas
 * 
 * - Usa la API Fetch para eliminar tareas mediante solicitudes AJAX al backend.
 * - Utiliza traducciones dinamicas desde `translations` cargado en `script_translations.js`
 * - Emplea `showDynamicConfirmModal()` para mostrar confirmaciones antes de implementar la acción
 */

import { htmlMessageZone, showDynamicConfirmModal, showDynamicEditModal, renderSelectFilter } from './script_helpers.js';

document.addEventListener('DOMContentLoaded', function() {
    // Agregar evento de click al botón de eliminar la Tarea
    document.querySelectorAll('.btn-eliminar-tarea').forEach(button => {
        button.addEventListener('click', function() {
            eliminarTarea(this);
        });
    });

    // Agregar evento de click al botón de editar la Tarea
    document.querySelectorAll('.btn-editar-tarea').forEach(button => {
        button.addEventListener('click', function() {
            editarTarea(this);
        });
    });
});

// Esperar a que las traducciones se cargan antes de ejecutar acciones
document.addEventListener('DOMContentLoaded', async () => {
    await loadTranslations();
});

/**
 * Function para manejar la eliminación de una tarea con confirmación
 * 
 * @param {Event} event - evento del click en el botón de eliminar.
 */
export function eliminarTarea(button) {
    // event.preventDefault(); // Evita el comportamiento predeterminado del enlace o boton

    // Referencia al contenedor de los mensajes
    const mensajeStatus = document.getElementById('mensajeStatus');

    // Obtener datos del div padre
    const card = button.closest('.tarea-card');
    if (!card) {
        // Mostrar mensaje de éxito si se borró correctamente
        mensajeStatus.innerHTML = htmlMessageZone(
            translations.ACCION_TAREA_CARD_ERR || `La clase <strong>"tarea-card"</strong> no existe.`, 
            '' 
        );
        return;
    }
    
    // Obtener datos de la tarea
    const tareaDatos = JSON.parse(atob(card.dataset.json));
    const rowId = tareaDatos.rowid;
    const nombreTarea = tareaDatos.nombre;

    // Mostrar el modal de confirmación antes de eliminar 
    showDynamicConfirmModal({
        title: translations.DYNAMIC_MODAL_BORRAR_TAREA_TITLE || 'Confirmación de eliminar tarea',
        body: `${translations.DYNAMIC_MODAL_BORRAR_TAREA_MSG || "¿Estás seguro de que deseas eliminar tarea:"}
            <br><snap style="color: blue;"><strong>"${nombreTarea}"</strong></snap><br>
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
            fetch(`${API_BASE_URL}/index.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    'r': 'tareas',
                    'action': 'AJAX_ELIMINAR_TAREA',
                    'rowId': rowId,                               // La clave de la tarea
                    'nombreTarea': nombreTarea                         // El nombre de la tarea
                })
            })
            .then(response => response.json())      // Convertir respuesta a JSON
            .then(data => {
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
                console.error('Error durante la solicitud AJAX:', error);
                // Mostrar mensaje de error si no se pudo completar la solicitud AJAX
                    mensajeStatus.innerHTML = htmlMessageZone(
                        translations.BORRAR_TAREA_FAIL || `Error al procesar solicitud AJAX.`, 
                        nombreTarea
                    );
            });
            // El final de la solicitud Fetch API al backend (controller.php)
        }
    });
}

/**
 * Function para manejar la actualización de una tarea con confirmación
 * 
 * @param {Event} event - evento del click en el botón de eliminar.
 */
export function editarTarea(button) {
    // Referencia al contenedor de los mensajes
    const mensajeStatus = document.getElementById('mensajeStatus');

    // Obtener datos del div padre
    const card = button.closest('.tarea-card');
    if (!card) {
        // Mostrar mensaje de éxito si se borró correctamente
        mensajeStatus.innerHTML = htmlMessageZone(
            translations.ACCION_TAREA_CARD_ERR || `La clase <strong>"tarea-card"</strong> no existe.`, 
            '' 
        );
        return;
    }
    
    // Obtener datos de la tarea
    const tareaDatos = JSON.parse(atob(card.dataset.json));

    // Solicitud AJAX para consultar la lista de los usuarios
    fetch(`${API_BASE_URL}/index.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            'r': 'adicional',
            'action': 'AJAX_LISTA_USUARIOS',
            'idUser_cargo': tareaDatos.idUser_cargo
        })
    })
    .then(response => response.json())      // Convertir respuesta a JSON
    .then(data => {
        if (data.success) {
            // Generar los elementos del select
            // Llamar a la función renderSelectFilter para generar el HTML del select usando los datos obtenidos
            const selectHTML_listaUsuarios = renderSelectFilter(
                'idDynamicSelectUserCargo', 
                'dynamicSelectUserCargo', 
                'form-select', 
                true, 
                false, 
                data.datos_usuarios);

            // Llamar a la función renderSelectFilter para generar el HTML del select de los estados de la tarea
            // Preparar los datos de los estados y de la tarea actual
            const datos_estadosTarea = [
                {
                    rowid: translations.APP_TAREA_ESTADO_ACTIVA || 'activa', 
                    name: translations.APP_TAREA_ESTADO_ACTIVA || 'activa', 
                    is_selected: tareaDatos.estado == translations.APP_TAREA_ESTADO_ACTIVA ? true : false,
                    iconClass: 'fa-solid fa-circle text-primary'        // Icono de FontAwesome con color azul
                },
                {
                    rowid: translations.APP_TAREA_ESTADO_PENDIENTE || 'pendiente', 
                    name: translations.APP_TAREA_ESTADO_PENDIENTE || 'pendiente',
                    is_selected: tareaDatos.estado == translations.APP_TAREA_ESTADO_PENDIENTE ? true : false,
                    iconClass: 'fa-solid fa-clock text-warning'        // Icono de FontAwesome con color amarillo
                },
                {
                    rowid: translations.APP_TAREA_ESTADO_FINALIZADA || 'finalizada', 
                    name: translations.APP_TAREA_ESTADO_FINALIZADA || 'finalizada',
                    is_selected: tareaDatos.estado == translations.APP_TAREA_ESTADO_FINALIZADA ? true : false,
                    iconClass: 'fa-solid fa-check-circle text-success'         // Icono de FontAwesome con color verde
                },
                {
                    rowid: translations.APP_TAREA_ESTADO_EN_MARCHA || 'en_marcha', 
                    name: translations.APP_TAREA_ESTADO_EN_MARCHA || 'en_marcha',
                    is_selected: tareaDatos.estado == translations.APP_TAREA_ESTADO_EN_MARCHA ? true : false,
                    iconClass: 'fa-solid fa-play-circle text-info'     // Icono de "play" azul claro
                },
                {
                    rowid: translations.APP_TAREA_ESTADO_CANCELADA || 'cancelada', 
                    name: translations.APP_TAREA_ESTADO_CANCELADA || 'cancelada',
                    is_selected: tareaDatos.estado == translations.APP_TAREA_ESTADO_CANCELADA ? true : false,
                    iconClass: 'fa-solid fa-times-circle text-danger'           // Icono de "X" con color rojo
                },
                {
                    rowid: translations.APP_TAREA_ESTADO_FALLADA || 'fallada', 
                    name: translations.APP_TAREA_ESTADO_FALLADA || 'fallada',
                    is_selected: tareaDatos.estado == translations.APP_TAREA_ESTADO_FALLADA ? true : false,
                    iconClass: 'fa-solid fa-exclamation-circle text-secondary'          // Icono de advertencia gris
                },
            ]
            const selectHTML_listaEstados = renderSelectFilter(
                'idDynamicSelectEstadoTarea', 
                'dynamicSelectEstadoTarea', 
                'form-select', 
                true, 
                false, 
                datos_estadosTarea,
                true                    // Habilitar icono externo
            );

            // Construir el cuerpo del formulario Modal con los datos de la tarea
            const formHTML = `
                <form id="editarTareaForm">
                    <div class="mb-3">
                        <label for="idEditNombreTarea" class="form-label">${translations.DYNAMIC_MODAL_EDITAR_TAREA_NOMBRE_LABEL || 'Nombre de la tarea'}:</label>
                        <input type="text" class="form-control" id="idEditNombreTarea" name="editNombreTarea" value="${tareaDatos.nombre}">
                    </div>
                    <div class="mb-3">
                        <label for="idEditDescripcionTarea">${translations.DYNAMIC_MODAL_EDITAR_TAREA_DESCRIPCION_LABEL || 'Descripción de la tarea'}:</label>
                        <textarea class="form-control" id="idEditDescripcionTarea" name="editDescripcionTarea">${tareaDatos.descripcion}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="idDynamicSelectUser">${translations.DYNAMIC_MODAL_EDITAR_TAREA_LISTA_USUARIOS_CARGO || 'Usuario a cargos'}:</label>
                        ${selectHTML_listaUsuarios}
                    </div>
                    <div class="mb-3">
                        <label for="idEditFechaInicioTarea">${translations.DYNAMIC_MODAL_EDITAR_TAREA_FECHA_INICIO || 'Fecha de inicio'}:</label>
                        <input type="date" class="form-control" id="idEditFechaInicioTarea" name="editFechaInicioTarea" value="${tareaDatos.inicio}">
                    </div>
                    <div class="mb-3">
                        <label for="idEditFechaFinTarea">${translations.DYNAMIC_MODAL_EDITAR_TAREA_FECHA_FINAL || 'Fecha de final'}:</label>
                        <input type="date" class="form-control" id="idEditFechaFinTarea" name="editFechaFinTarea" value="${tareaDatos.final}">
                    </div>
                    <div class="mb-3">
                        <label for="idDynamicSelectEstadoTarea">${translations.DYNAMIC_MODAL_EDITAR_TAREA_ESTADO_LABEL || 'Estado de la tarea'}:</label>
                        ${selectHTML_listaEstados}
                    <input type="hidden" id="idEditRowId" value="${tareaDatos.rowId}">
                </form>
            `;

            // Mostrar el modal con el formulario
            showDynamicEditModal({
                title: translations.DYNAMIC_MODAL_EDITAR_TAREA_TITLE || 'Editar tarea',
                body: formHTML,
                confirmText: translations.DYNAMIC_MODAL_EDITAR_TAREA_YES_BUTTON || 'Guardar',
                cancelText: translations.DYNAMIC_MODAL_EDITAR_TAREA_NO_BUTTON || 'Cancelar',
                confirmBtnClass: 'btn btn-primary',
                cancelBtnClass: 'btn btn-secondary',
                estadoEstilo: tareaDatos.estado,

                onConfirm: function() {
                    // Obtener los valores del formulario
                    const editRowId = document.getElementById('idEditRowId').value;
                    const nombreTarea = document.getElementById('idEditNombreTarea').value;
                    const descripcionTarea = document.getElementById('idEditDescripcionTarea').value;
                    const idDynamicSelectUser = document.getElementById('idDynamicSelectUser').value;

                    // Solicitud AJAX para editar la tarea
                    fetch(`${API_BASE_URL}/index.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new URLSearchParams({
                            'r': 'tareas',
                            'action': 'AJAX_EDITAR_TAREA',
                            'rowId': editRowId,                                 // La clave de la tarea
                            'nombreTarea': nombreTarea,                         // El nombre de la tarea
                            'descripcionTarea': descripcionTarea,               // La descripción de la tarea
                            'idUsuario': idDynamicSelectUser,                   // El ID del usuario
                            'estadoEstilo': estadoEstilo
                        })
                    })
                    .then(response => response.json())      // Convertir respuesta a JSON
                    .then(data => {
                        if (data.success) {
                            // Mostrar mensaje de éxito si se editó correctamente
                            mensajeStatus.innerHTML = htmlMessageZone(
                                translations.EDITAR_TAREA_EXITO || `La tarea "${nombreTarea}" ha sido editada correctamente.`, 
                                nombreTarea 
                            );
                        } else {
                            // Mostrar mensaje de error si no se pudo editar la tarea
                            mensajeStatus.innerHTML = htmlMessageZone(
                                translations.EDITAR_TAREA_ERROR || `Error al intentar editar la tarea ${data.msg}.`, 
                                data.msg 
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error durante la solicitud AJAX:', error);
                        // Mostrar mensaje de error si no se pudo completar la solicitud AJAX
                        mensajeStatus.innerHTML = htmlMessageZone(
                            translations.EDITAR_TAREA_FAIL || `Error al procesar solicitud AJAX.`, 
                            nombreTarea 
                        );
                    });
                }
            });
        } else {
            // Mostrar mensaje de error si no se pudo borra la tarea
            mensajeStatus.innerHTML = htmlMessageZone(
                translations.LISTA_USUARIOS_ERROR || `Error al consultar la lista de los usuarios.`, 
                '' 
            );
        }
    })
    .catch(error => {
        console.error('Error durante la solicitud AJAX:', error);
        // Mostrar mensaje de error si no se pudo completar la solicitud AJAX
        mensajeStatus.innerHTML = htmlMessageZone(
            translations.EDITAR_TAREA_FAIL || `Error al procesar solicitud AJAX.`, 
            tareaDatos.nombre
        );
    });
}