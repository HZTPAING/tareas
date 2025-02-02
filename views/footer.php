<?php
    // Obtener el servicio de traducción desde el contenedor global
    global $container;
    $translator = $container['translator'];
?>

        <!-- Inicio del pie de página -->
        <footer>
            <script>
                // Definir la constante BASE_URL para usar en scripts
                const BASE_URL = '<?php echo BASE_URL; ?>';
            </script>
            
            <!-- === Scripts de la aplicación === -->
            <!-- Script principal para funciones globales -->
            <script src="<?= BASE_URL . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'script.js'; ?>"></script>
            <!-- Scripts específicos para la página de tareas -->
            <script src="<?= BASE_URL . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'script_tareas.js'; ?>"></script>
            <!-- Script para manejar modales dinámicos de confirmación -->
            <script src="<?= BASE_URL . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'script_dynamicConfirmModal.js'; ?>"></script>
            
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