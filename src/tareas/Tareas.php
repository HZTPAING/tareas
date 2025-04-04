<?php
    namespace Hztpaing\Tareas\src\tareas;
    
    /**
     * Clase Tareas
     * 
     * Representa el tablero de las tareas y proporciona métodos para generar
     * su representación visual en formato HTML.
     */

    class Tareas {
        // Atributos de la tarea
        private $rowid;             // 12                           Identificador único de la tarea
        private $idUser;            // 58                           ID del usuario creador
        private $name_user;         // HZTPASERG                    Nombre del usuario creador
        private $idUser_cargo;      // 59                           ID del usuario asignado
        private $name_user_cargo;   // GRIASERHII                   Nombre del usuario asignado
        private $nombre;            // TAREA_01                     Nombre de la tarea
        private $descripcion;       // Descripcion de la TAREA_01   Descripción de la tarea
        private $inicio;            // 2025-01-24                   Fecha de inicio
        private $final;             // 2025-01-31                   Fecha de finalización
        private $estadoID;          // 0                            ID del estado de la tarea
        public $estado;            // finalizada                   Nombre del estado de la tarea
        private $translator;        // Servicio de traducción
        private $htmlHelper;        // Servisio de la clase auxiliar HtmlHelper

        /**
         * Constructor de la clase Tareas
         * 
         * @param int $rowid ID único de la tarea.
         * @param int $idUser ID del usuario creador.
         * @param string $name_user Nombre del usuario creador.
         * @param int $idUser_cargo ID del usuario asignado.
         * @param string $name_user_cargo Nombre del usuario asignado.
         * @param string $nombre Nombre de la tarea.
         * @param string $descripcion Descripción de la tarea.
         * @param string $inicio Fecha de inicio.
         * @param string $final Fecha de finalización.
         * @param int $estadoID ID del estado.
         * @param string $estado Nombre del estado.
         */
        public function __construct(
            $rowid, 
            $idUser, 
            $name_user, 
            $idUser_cargo, 
            $name_user_cargo, 
            $nombre, 
            $descripcion, 
            $inicio, 
            $final, 
            $estadoID, 
            $estado
        ) {
            $this->rowid = $rowid;
            $this->idUser = $idUser;
            $this->name_user = $name_user;
            $this->idUser_cargo = $idUser_cargo;
            $this->name_user_cargo = $name_user_cargo;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->inicio = $inicio;
            $this->final = $final;
            $this->estadoID = $estadoID;
            $this->estado = $estado;

            // Obtener las instancias necesaria desde el contenedor
            global $container;
            $this->translator = $container['translator'];   // Servicio de traducción
            $this->htmlHelper = $container['htmlHelper'];   // Servicio para utilizar las finciones auxiliares
        }

        /**
         * Método mágico para convertir la tarea en un fragmento de HTML
         *
         * @return string Código HTML que representa la tarea.
         */
        public function __toString()
        {
            // Clase CSS según el estado de la tarea
            $estadoColorClass = $this->htmlHelper->getEstadoColorClass($this->estado);

            // Generar JSON codificado enBase64 para evitar caracteres especiales 
            $jsonDataTarea = base64_encode(json_encode([
                'rowid' => $this->rowid,
                'idUser' => $this->idUser,
                'name_user' => $this->name_user,
                'idUser_cargo' => $this->idUser_cargo,
                'name_user_cargo' => $this->name_user_cargo,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'inicio' => $this->inicio,
                'final' => $this->final,
                'estadoID' => $this->estadoID,
                'estado' => $this->htmlHelper->ajustarEstadoToLocale($this->estado)
            ]));

            // Generar el código HTML de la card
            return sprintf(
                '
                    <div class="card tarea-card %s m-2" style="width: 18rem;" data-json="%s">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="fw-bold">%s</span>
                            <span class="badge %s">%s</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">%s</p>
                            <p class="card-text">%s</p>
                            <p class="card-text">%s</p>
                            <p class="card-text">%s</p>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary btn-editar-tarea btn-sm"
                            >%s</button>
                            <button class="btn btn-danger btn-eliminar-tarea btn-sm"
                            >%s</button>
                        </div>
                    </div>
                ',
                htmlspecialchars($estadoColorClass, ENT_NOQUOTES, 'UTF-8'),
                $jsonDataTarea,             // Guardamos el JSON en el div principal
                htmlspecialchars($this->nombre, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($this->htmlHelper->getBadgeColorClass($this->estado), ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($this->htmlHelper->ajustarEstadoToLocale($this->estado), ENT_QUOTES, 'UTF-8'),
                sprintf(htmlspecialchars_decode($this->translator->trans('APP_TAREA_CARD_DESCRIPTION'), ENT_QUOTES), htmlspecialchars($this->descripcion, ENT_QUOTES, 'UTF-8')),
                sprintf(htmlspecialchars_decode($this->translator->trans('APP_TAREA_CARD_USER_ASIGN'), ENT_QUOTES), htmlspecialchars($this->name_user_cargo, ENT_QUOTES, 'UTF-8')),
                sprintf(htmlspecialchars_decode($this->translator->trans('APP_TAREA_CARD_DATE_START'), ENT_QUOTES), htmlspecialchars($this->inicio, ENT_QUOTES, 'UTF-8')),
                sprintf(htmlspecialchars_decode($this->translator->trans('APP_TAREA_CARD_DATE_END'), ENT_QUOTES), htmlspecialchars($this->final, ENT_QUOTES, 'UTF-8')),
                htmlspecialchars_decode($this->translator->trans('APP_TAREA_CARD_BOTON_EDIT'), ENT_QUOTES),
                htmlspecialchars_decode($this->translator->trans('APP_TAREA_CARD_BOTON_DEL'), ENT_QUOTES)
            );
            
        }

        /**
         * Determina la clase CSS del color según el estado de la tarea.
         * 
         * @param string $estado Nombre del estado de la tarea.
         * @return string Clase CSS asociada al estado.
         */
        private function getEstadoColorClass($estado): string {
            // Ajustar el estado al idioma actual
            $estadoAjustado = match (strtolower($estado)) {
                'activa', 'active' => $this->translator->trans('APP_TAREA_ESTADO_ACTIVA'),
                'pendiente', 'pending' => $this->translator->trans('APP_TAREA_ESTADO_PENDIENTE'),
                'finalizada', 'completed' => $this->translator->trans('APP_TAREA_ESTADO_FINALIZADA'),
                'en_marcha', 'in_progress' => $this->translator->trans('APP_TAREA_ESTADO_EN_MARCHA'),
                'cancelada', 'cancelled' => $this->translator->trans('APP_TAREA_ESTADO_CANCELADA'),
                'fallada', 'failed' => $this->translator->trans('APP_TAREA_ESTADO_FALLADA'),
                default => strtolower($estado),
            };

            return match ($estadoAjustado) {
                $this->translator->trans('APP_TAREA_ESTADO_ACTIVA') => "card-activa",
                $this->translator->trans('APP_TAREA_ESTADO_PENDIENTE') => "card-pendiente",
                $this->translator->trans('APP_TAREA_ESTADO_FINALIZADA') => "card-finalizada",
                $this->translator->trans('APP_TAREA_ESTADO_EN_MARCHA') => "card-en-marcha",
                $this->translator->trans('APP_TAREA_ESTADO_CANCELADA') => "card-cancelada",
                $this->translator->trans('APP_TAREA_ESTADO_FALLADA') => "card-fallada",
                default => "card-default",
            };
        }

        /**
         * Determina la clase CSS del badge según el estado de la tarea.
         * 
         * @param string $estado Nombre del estado de la tarea.
         * @return string Clase CSS asociada al badge.
         */
        private function getBadgeColorClass($estado): string {
            // Ajustar el estado al idioma actual
            $estadoAjustado = match (strtolower($estado)) {
                'activa', 'active' => $this->translator->trans('APP_TAREA_ESTADO_ACTIVA'),
                'pendiente', 'pending' => $this->translator->trans('APP_TAREA_ESTADO_PENDIENTE'),
                'finalizada', 'completed' => $this->translator->trans('APP_TAREA_ESTADO_FINALIZADA'),
                'en_marcha', 'in_progress' => $this->translator->trans('APP_TAREA_ESTADO_EN_MARCHA'),
                'cancelada', 'cancelled' => $this->translator->trans('APP_TAREA_ESTADO_CANCELADA'),
                'fallada', 'failed' => $this->translator->trans('APP_TAREA_ESTADO_FALLADA'),
                default => strtolower($estado),
            };

            return match (strtolower($estadoAjustado)) {
                $this->translator->trans('APP_TAREA_ESTADO_ACTIVA') => "bg-primary",                       // Azul
                $this->translator->trans('APP_TAREA_ESTADO_PENDIENTE') => "bg-warning text-dark",          // Amarillo
                $this->translator->trans('APP_TAREA_ESTADO_FINALIZADA') => "bg-success",                   // Verde
                $this->translator->trans('APP_TAREA_ESTADO_EN_MARCHA') => "bg-orange",                     // Naranja  (debes definir esta clase en CSS)
                $this->translator->trans('APP_TAREA_ESTADO_CANCELADA') => "bg-danger",                     // Rojo
                $this->translator->trans('APP_TAREA_ESTADO_FALLADA') => "bg-purple text-light",            // Púrpura (debes definir esta clase en CSS)
                default => "bg-secondary",
            };
        }

        /**
         * Ajustar el nombre del "badge" de estado de la tarea al idioma actual
         * 
         * @param string $estado Nombre del estado de la tarea
         * @return string Nombre del estado de la tarea ajustado al idioma actual
         */
        private function ajustarEstadoToLocale($estado): string {
            return match (strtolower($estado)) {
                'activa', 'active' => $this->translator->trans('APP_TAREA_ESTADO_ACTIVA'),
                'pendiente', 'pending' => $this->translator->trans('APP_TAREA_ESTADO_PENDIENTE'),
                'finalizada', 'completed' => $this->translator->trans('APP_TAREA_ESTADO_FINALIZADA'),
                'en_marcha', 'in_progress' => $this->translator->trans('APP_TAREA_ESTADO_EN_MARCHA'),
                'cancelada', 'cancelled' => $this->translator->trans('APP_TAREA_ESTADO_CANCELADA'),
                'fallada', 'failed' => $this->translator->trans('APP_TAREA_ESTADO_FALLADA'),
                default => strtolower($estado),
            };
        }
    }