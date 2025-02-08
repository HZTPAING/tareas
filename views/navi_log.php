<?php
/**
 * Vista de navegación "Navi Log"
 * 
 * Esta vista presenta un menú de navegación simplificado con un botón para regresar
 * a la página principal. Es útil para páginas de login u otras que no necesitan
 * un menú completo.
 */

 // Obtener el servicio de traducción desde el contenedor global
    global $container;
    $translator = $container['translator'];
    $htmlHelper = $container['htmlHelper'];
?>

<nav class="navbar navbar-expand-lg bg-light shadow-sm">
    <div class="container-fluid">
        <!-- Marca o logo opcional -->
        <a class="navbar-brand text-primary fw-bold" href="<?= BASE_URL ?>">
            <?= htmlspecialchars($translator->trans('APP_TITULO')); // Título de la aplicación ?>
        </a>

        <!-- Elementos colapsables del menú -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent_maine">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Aquí puedes agregar enlaces adicionales al menú si es necesario -->
            </ul>

            <!-- Botones del menú derecho -->
            <div class="d-flex align-items-center gap-3">
                <!-- Texto adicional o elementos futuros -->
                <span class="navbar-text text-secondary">
                    <?= htmlspecialchars($translator->trans('APP_BARRA_MENU')); // Texto traducido para el menú ?>
                </span>

                <!-- Botón para regresar a la página principal -->
                <a 
                    class="btn btn-danger d-flex align-items-center gap-2" 
                    href="<?= BASE_URL . DIRECTORY_SEPARATOR . 'index.php' ?>"
                >
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <?= htmlspecialchars($translator->trans('APP_LOGOUT')); // Texto traducido para "Salir" ?>
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