<?php
/**
 * Vista principal de la aplicación: Home
 * 
 * Esta vista presenta la página inicial con un menú de navegación 
 * que incluye enlaces a las secciones principales: Productos y Tareas.
 * 
 * Las rutas se generan dinámicamente utilizando la constante BASE_URL.
 */

    // Obtener el servicio de traducción desde el contenedor global
    global $container;
    $translator = $container['translator'];
?>

<section class="container-fluid">
    <!-- Zona superior -->
    <nav class="d-flex justify-content-between align-items-center p-3 bg-primary text-white border rounded">
        
        <!-- Sección izquierda: Logo y menú de navegación -->
        <div class="d-flex align-items-center gap-3">
            
            <!-- Logo de la aplicación -->
            <img 
                src="https://w7.pngwing.com/pngs/662/750/png-transparent-file-manager-computer-icons-file-explorer-android-android-blue-rectangle-electric-blue.png" 
                alt="Logo de la aplicación" 
                style="height: 50px;"
                class="img-fluid"
            >
            
            <!-- Menú de navegación principal -->
            <nav class="d-flex gap-3">
                <a href="#" class="text-white fw-bold text-decoration-none">
                    <?= $translator->trans('APP_PRODUCTOS'); // Texto traducido para "Productos" ?>
                </a>
                <a href="<?= BASE_URL . DIRECTORY_SEPARATOR . 'index.php?r=login'; ?>" class="text-white fw-bold text-decoration-none">
                    <?= $translator->trans('APP_TAREAS'); // Texto traducido para "Tareas" ?>
                </a>
            </nav>
        </div>

        <!-- Zona derecha: Espacio adicional para futuros elementos (ejemplo: usuario, notificaciones) -->
        <div>
            <!-- Aquí se pueden incluir elementos adicionales en el futuro -->
        </div>
    </nav>
</section>