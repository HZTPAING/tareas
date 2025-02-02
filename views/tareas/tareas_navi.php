<?php
    // Asegurar que los servicios necesarios estén disponibles desde el contenedor
    global $container;
    $translator = $container['translator'];         // Servicio de traducción
    $htmlHelper = $container['htmlHelper'];         // Servicio para generar HTML dinámico

    /**
     * Vista del menú de navegación para la sección de Tareas
     * 
     * Este menú incluye un saludo dinámico al usuario, opciones de configuración 
     * como cambio de idioma y un botón para cerrar sesión.
     */
?>

<nav class="navbar navbar-expand-lg bg-light shadow">
    <div class="container-fluid">
        <!-- Título de la barra de navegación -->
        <a class="navbar-brand fw-bold text-primary" href="<?= BASE_URL . '/index.php?r=login' ?>">
            <?= htmlspecialchars($translator->trans('APP_TITULO_TAREAS'), ENT_QUOTES, 'UTF-8');    // Título traducido ?>
        </a>

        <!-- Botón de menú hamburguesa para dispositivos pequeños -->
        <button 
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent_maine" 
            aria-controls="navbarSupportedContent_maine" 
            aria-expanded="false" 
            aria-label="<?= htmlspecialchars($translator->trans('APP_TOGGLE_MENU'), ENT_QUOTES, 'UTF-8');   // Traducción de la etiqueta para el menú hamburguesa ?>">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido del menú -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent_maine">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Elementos dinámicos del menú (se añadirán funcionalidades más adelante) -->
            </ul>
            <div class="d-flex align-items-center">
                <!-- Saludo dinámico al usuario -->
                <div class="navbar-text me-3">
                    <?= htmlspecialchars($translator->trans('APP_BIENVENIDO', ENT_QUOTES, 'UTF-8')); // Texto de bienvenida ?>
                    <strong>
                        <?php
                            // Nombre del usuario logueado o 'Invitado' si no hay sesión activa
                            $usuarioLoqueado = $_SESSION['name'] ?? 'Invitado';
                            
                            // Mostrar el saludo al usuario
                            echo $htmlHelper->htmlSaludo($usuarioLoqueado);
                        ?>
                    </strong>
                </div>

                <!-- Botón para cambiar el idioma -->
                <form method="post" action="<?= BASE_URL . DIRECTORY_SEPARATOR . 'index.php?r=tareas_listado&action=cambiarIdioma'; ?>" class="me-3">
                    <select 
                        name="locale" 
                        class="form-select form-select-sm" 
                        onchange="this.form.submit()"
                        aria-label="<?= htmlspecialchars($translator->trans('APP_CAMBIAR_IDIOMA'), ENT_QUOTES, 'UTF-8'); ?>"> // Etiqueta para el selector de idioma ?>"
                        <option value="es" <?= APP_LOCALE === 'es' ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($translator->trans('APP_IDIOMA_ES'), ENT_QUOTES, 'UTF-8'); // Opción para el idioma español ?>
                        </option>
                        <option value="en" <?= APP_LOCALE === 'en' ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($translator->trans('APP_IDIOMA_EN'), ENT_QUOTES, 'UTF-8'); // Opción para el idioma inglés ?>
                        </option>
                    </select>
                </form>
                <!-- Botón para cerrar sesión -->
                <a class="btn btn-danger d-flax align-items-center"
                    href="<?= BASE_URL . DIRECTORY_SEPARATOR . 'index.php?action=FORM_LOGOUT&r=login'; ?>"
                    aria-label="<?= htmlspecialchars($translator->trans('APP_CERRAR_SESION'), ENT_QUOTES, 'UTF-8'); ?>  // Etiqueta para el botón de cerrar sesión ?>""
                >
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
<!-- Cabecera con espacio para mensajes de respuesta -->
<header class="container-fluid py-3 bg-light">
    <!-- Mensaje de respuesta dinámico -->
    <div id="res" class="message-res">
        <?php
            // Verificar si hy mensajes de respuesta y mostrarlos de forma segura
            if (isset($_GET['resData']) && isset($_GET['resCode'])) {
                echo $htmlHelper->htmlMessageZone($_GET['resCode'], $_GET['resData']);
            }
        ?>
    </div>
</header>