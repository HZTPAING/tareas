<?php
    // Obtener el servicio de traducción desde el contenedor global
    global $container;
    $translator = $container['translator'];
?>

        <!-- Inicio del pie de página -->
        <footer>
            <!-- === Scripts de la aplicación === -->
            <!-- Script de la auxiliar de generar etiqueta SELECT -->
            <script type="module" src="<?= BASE_URL . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'SelectElementJS.js'; ?>" ></script>
            <!-- Script de las funciones auxiliares -->
            <script type="module" src="<?= BASE_URL . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'script_helpers.js'; ?>" ></script>
            <!-- Scripts específicos para la página de tareas -->
            <script type="module" src="<?= BASE_URL . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'script_tareas.js'; ?>" ></script>
            <!-- Script para manejar modales dinámicos de confirmación -->
            <script src="<?= BASE_URL . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'script_dynamicConfirmModal.js'; ?>"></script>
            
            <!-- === Librerías externas === -->
            <!-- Popper.js para manejo de tooltips y popovers -->
            <script 
                src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" 
                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" 
                crossorigin="anonymous">
            </script>
            <!-- Bootstrap para componentes dinámicos como tooltips, modales y otros -->
            <script 
                src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" 
                integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" 
                crossorigin="anonymous">
            </script>

            <!-- === Contenedor para contenido dinámico del pie de página === -->
            <section id="idFooter">
                <!-- Este contenedor se puede usar para inyectar contenido dinámico vía JavaScript -->
            </section>
        </footer>

    </body>

</html>