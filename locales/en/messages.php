<?php
return [
    // Application messages
    'APP_BIENVENIDO' => 'Hello, welcome to the WEB application:',
    'APP_TITULO' => 'TASKS',
    'APP_DESCRIPCION' => 'PHP library for managing tasks',
    'APP_LOGO' => '[Creation date - 01/29/2025]',
    'APP_BARRA_MENU' => 'The Task Application',
    'APP_LOGO_HOME' => 'TASK MANAGEMENT',

    // ERROR messages
    'ERR_PROCES_CONTRAS_VACIA' => 'The password must be a non-empty string.',
    'ERR_RUTA_VISTAS_NO_VALIDA' => 'The provided view path is not valid.',
    'ERR_VISTA_NO_EXISTE' => 'The specified view does not exist.',
    'ERR_PLANTILLA_NO_EXISTE' => 'The specified template does not exist.',
    'ERR_ENV_NO_CARGA' => 'Error loading environment file.',
    'ERR_CODE_NOT_DEFINED' => "The message code '%s' is not defined in the translations.",

    // LOGIN view ERROR messages
    'LOGIN_ERROR' => [
        'type' => 'danger',
        'msg' => 'The user <strong>%s</strong> did NOT log in successfully.<br>The password or email is incorrect.'
    ],
    'LOGIN_SUCCESS' => [
        'type' => 'success',
        'msg' => 'The user <strong>%s</strong> has successfully logged in.'
    ],

    // TASKS view ERROR messages
    'TABLERO_SIN_TAREAS' => [
        'type' => 'danger',
        'msg' => 'There are no tasks available to display on the board.',
    ],
    'APP_TABLERO_TAREAS' => 'Task Board',

    // DynamicConfirmModal window messages
    'DYNAMIC_MODAL_TITLE' => 'Confirm action',
    'DYNAMIC_MODAL_MSG' => 'Are you sure you want to perform this action?',
    'DYNAMIC_MODAL_WARNING' => 'This action cannot be undone',
    'DYNAMIC_MODAL_YES_BUTTON' => 'Confirm',
    'DYNAMIC_MODAL_NO_BUTTON' => 'Cancel',

    // DynamicConfirmModal window messages - Delete Task
    'DYNAMIC_MODAL_BORRAR_TAREA_TITLE' => 'Confirm Task Deletion',
    'DYNAMIC_MODAL_BORRAR_TAREA_MSG' => 'Are you sure you want to delete this task?',
    'DYNAMIC_MODAL_BORRAR_TAREA_WARNING' => 'This action cannot be undone',
    'DYNAMIC_MODAL_BORRAR_TAREA_YES_BUTTON' => 'Delete',
    'DYNAMIC_MODAL_BORRAR_TAREA_NO_BUTTON' => 'Cancel',

    // SUCCESS message for deleting a task
    'BORRAR_TAREA_EXITO' => [
        'type' => 'success',
        'msg' => '<strong>Success:</strong> The task <strong>%s</strong> has been successfully deleted.'
    ],

    // ERROR message for deleting a task
    'BORRAR_TAREA_ERROR' => [
        'type' => 'danger',
        'msg' => '<strong>Error:</strong> Failed to delete task <strong>%s</strong>.'
    ],

    // FAIL message for deleting a task
    'BORRAR_TAREA_FAIL' => [
        'type' => 'danger',
        'msg' => 'Error processing AJAX request.'
    ],

    // Main menu of the application
    'APP_PRODUCTOS' => 'Products',
    'APP_TAREAS' => 'Tasks',
    'APP_BARRA_MENU' => 'Task Management',
    'APP_LOGOUT' => '',
    'APP_USUARIO' => 'User',
    'APP_NOTIFICACIONES' => 'Notifications',
    'APP_TITULO_TAREAS' => 'Task Management',
    'APP_TOGGLE_MENU' => 'Open navigation menu',
    'APP_CAMBIAR_IDIOMA' => 'Change language',
    'APP_IDIOMA_ES' => 'Spanish',
    'APP_IDIOMA_EN' => 'English',
    'APP_CERRAR_SESION' => 'Logout',
    'APP_BIENVENIDO' => 'Welcome,',

    // Login form translations
    'APP_LOGIN_FORM' => 'Login Form',
    'APP_EMAIL' => 'Email Address',
    'APP_PLACEHOLDER_EMAIL' => 'Enter your email address',
    'APP_PASSWORD' => 'Password',
    'APP_PLACEHOLDER_PASSWORD' => 'Enter your password',
    'APP_LOGIN_BUTTON' => 'Log in',
    'APP_RESET_BUTTON' => 'Reset',
];
