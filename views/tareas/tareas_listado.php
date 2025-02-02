<?php
/**
 * Vista: Listado de Tareas
 * 
 * Genera dinámicamente el tablero de tareas similar al estilo de Trello.
 * Las tareas se muestran como tarjetas en un contenedor utilizando la clase `Tareas`.
 */
    // Obtener las instancias necesarias desde el contenedor
    global $container;
    $translator = $container['translator']; // Servicio de traducción
    $htmlHelper = $container['htmlHelper']; // Servicio para generar HTML dinámico

    // Importar la clase Tareas desde el namespace Tareasing
    use Hztpaing\Tareas\src\tareas\Tareas;

    // Verificar si el array de datos de tareas está disponible y contiene elementos
    if (!isset($datosTareas_user) || empty($datosTareas_user)) {
        // Generar mensaje de error si no hay tareas disponibles con HtmlHelper
        echo $htmlHelper->htmlMessageZone('TABLERO_SIN_TAREAS', null);
        exit();    // Salir si no hay tareas disponibles
    }

    // Inicia la sección del tablero de tareas
?>
    <section class="custom-container">
        <h3 class="text-center text-primary mb-4">
            <?= htmlspecialchars($translator->trans('APP_TABLERO_TAREAS'), ENT_QUOTES, 'UTF-8'); // Texto traducido: "Tablero de Tareas" ?>
        </h3>
        <div class="tareas-container d-flex flex-wrap justify-content-start">
            <?php
            // Iterar a través de los datos de las tareas para generar tarjetas
            foreach ($datosTareas_user as $datosTarea) {
                // Crear una instancia de la clase Tareas para cada tarea
                $tareaObj = new Tareas (
                    $datosTarea['rowid'],
                    $datosTarea['idUser'],
                    $datosTarea['name_user'],
                    $datosTarea['idUser_cargo'],
                    $datosTarea['name_user_cargo'],
                    $datosTarea['nombre'],
                    $datosTarea['descripcion'],
                    $datosTarea['inicio'],
                    $datosTarea['final'],
                    $datosTarea['estadoID'],
                    $datosTarea['estado']
                );

                // Mostrar la tarjeta utilizando el método __toString()
                echo $tareaObj;
            }
        ?>
    </div>
</section>