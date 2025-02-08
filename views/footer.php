<?php
    // Obtener el servicio de traducción desde el contenedor global
    global $container;
    $translator = $container['translator'];
?>

        <!-- Inicio del pie de página -->
        <footer>
            <!-- === Scripts de la aplicación === -->
            <!-- Scripts específicos para la página de tareas -->
            <script src="<?= BASE_URL . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'script_tareas.js'; ?>"></script>
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

        <!-- Modal de confirmación -->
        <div 
            class="modal fade" 
            id="dynamicConfirmModal" 
            tabindex="-1" 
            aria-labelledby="dynamicConfirmModalLabel" 
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 
                            class="modal-title"
                            id="dynamicConfirmModalLabel"
                            style="color: white;"
                        >
                            Confirmar borrado
                        </h5>
                        <button 
                            type="button" 
                            class="btn-close" 
                            data-bs-dismiss="modal" 
                            aria-label="Close"
                        ></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        ¿Estás seguro de que deseas realizar esta acción?
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            data-bs-dismiss="modal" 
                            id="cancelBtn"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="button" 
                            class="btn btn-danger" 
                            id="confirmBtn"
                        >
                            Borrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>