<?php
return [
    // Mensajes de la aplicación
    'APP_BIENVENIDO' => 'Hola, bienvenido a la aplicación WEB:',
    'APP_TITULO' => 'TAREAS',
    'APP_DESCRIPCION' => 'Librería PHP de las clases para gestionar las tareas',
    'APP_LOGO' => '[El día de crear - 01/29/2025]',
    'APP_BARRA_MENU' => 'La Aplicación de las Tareas',
    'APP_LOGO_HOME' => 'GESTIÓN DE LAS TAREAS',

    // Mensajes de ERROR
    'ERR_PROCES_CONTRAS_VACIA' => 'La contraseña debe ser una cadena no vacía.',
    'ERR_RUTA_VISTAS_NO_VALIDA' => 'La ruta de vistas proporcionada no es válida',
    'ERR_VISTA_NO_EXISTE' => 'La vista especificada no existe',
    'ERR_PLANTILLA_NO_EXISTE' => 'La plantilla especificada no existe',
    'ERR_ENV_NO_CARGA' => 'Error al cargar el archivo de entorno',
    'ERR_CODE_NOT_DEFINED' => "El código de mensaje '%s' no está definido en las traducciones.",

    // Mendajes de ERROR en la vista LOGIN
    'LOGIN_ERROR' => [
        'type' => 'danger',
        'msg' => 'El usuario <strong>%s</strong> NO ha iniciado sesión con exito<br>La contraseña o el correo no es correcto.'
    ],
    'LOGIN_SUCCESS' => [
        'type' => 'success',
        'msg' => 'El usuario <strong>%s</strong> ya ha iniciado sesión con exito.'
    ],

    // Mensajes de ERROR en la vista de TAREAS
    'TABLERO_SIN_TAREAS' => [
        'type' => 'danger',
        'msg' => 'No hay tareas disponibles para mostrar en el tablero.',
    ],
    'APP_TABLERO_TAREAS' => 'Tablero de Tareas',

    // Mensajes de la ventana modal DynamicConfirmModal
    'DYNAMIC_MODAL_TITLE' => 'Confirmar acción',
    'DYNAMIC_MODAL_MSG' => '¿Estás seguro de que deseas realizar esta acción?',
    'DYNAMIC_MODAL_WARNING' => 'Esta acción no se puede deshaser',
    'DYNAMIC_MODAL_YES_BUTTON' => 'Confirmar',
    'DYNAMIC_MODAL_NO_BUTTON' => 'Cancelar',

    // Mensajes de la ventana modal DynamicConfirmModal Eliminar TAREA
    'DYNAMIC_MODAL_BORRAR_TAREA_TITLE' => 'Confirmar acción de elimiar tarea',
    'DYNAMIC_MODAL_BORRAR_TAREA_MSG' => '¿Estás seguro de que deseas eliminar tarea?',
    'DYNAMIC_MODAL_BORRAR_TAREA_WARNING' => 'Esta acción no se puede deshaser',
    'DYNAMIC_MODAL_BORRAR_TAREA_YES_BUTTON' => 'Borrar',
    'DYNAMIC_MODAL_BORRAR_TAREA_NO_BUTTON' => 'Cancelar',

    // Mensaje de EXITO de elimin la TAREA
    'BORRAR_TAREA_EXITO' => [
        'type' =>'success',
        'msg' => '<strong>Exito:</strong> La tarea <strong>%s</strong> ha sido eliminada correctamente.'
    ],

    // Mensaje de ERROR de elimin la TAREA
    'BORRAR_TAREA_ERROR' => [
        'type' =>'danger',
        'msg' => '<strong>Error:</strong> Error al intentar eliminar la tarea <strong>%s</strong>.'
    ],

    // Mensaje de FAIL de elimin la TAREA
    'BORRAR_TAREA_FAIL' => [
        'type' =>'danger',
        'msg' => 'Error al procesar solicitud AJAX.'
    ],

    // Menu principal de la app
    'APP_PRODUCTOS' => 'Productos',
    'APP_TAREAS' => 'Tareas',
    'APP_BARRA_MENU' => 'Gestión de tareas',
    'APP_LOGOUT' => '',
    'APP_USUARIO' => 'Usuario',
    'APP_NOTIFICACIONES' => 'Notificaciones',
    'APP_TITULO_TAREAS' => 'Gestión de Tareas',
    'APP_TOGGLE_MENU' => 'Abrir menú de navegación',
    'APP_CAMBIAR_IDIOMA' => 'Cambiar idioma',
    'APP_IDIOMA_ES' => 'Español',
    'APP_IDIOMA_EN' => 'Inglés',
    'APP_CERRAR_SESION' => 'Cerrar sesión',
    'APP_BIENVENIDO' => 'Bienvenido,',

    // Traducciones del formulario de login
    'APP_LOGIN_FORM' => 'Formulario de Acceso',
    'APP_EMAIL' => 'Correo Electrónico',
    'APP_PLACEHOLDER_EMAIL' => 'Introduce tu correo electrónico',
    'APP_PASSWORD' => 'Contraseña',
    'APP_PLACEHOLDER_PASSWORD' => 'Introduce tu contraseña',
    'APP_LOGIN_BUTTON' => 'Iniciar sesión',
    'APP_RESET_BUTTON' => 'Reiniciar',
];