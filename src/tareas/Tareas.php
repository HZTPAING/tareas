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
        private $estado;            // finalizada                   Nombre del estado de la tarea

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
        }

        /**
         * Método mágico para convertir la tarea en un fragmento de HTML
         *
         * @return string Código HTML que representa la tarea.
         */
        public function __toString()
        {
            // Clase CSS según el estado de la tarea
            $estadoColorClass = $this->getEstadoColorClass($this->estado);

            // Generar el código HTML de la card
            return sprintf(
                '
                    <div class="card tarea-card %s m-2" style="width: 18rem;">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="fw-bold">%s</span>
                            <span class="badge %s">$s</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Descripción:</strong> %s</p>
                            <p class="card-text"><strong>Usuario Asignado:</strong> %s</p>
                            <p class="card-text"><strong>Fecha Inicio:</strong> %s</p>
                            <p class="card-text"><strong>Fecha Final:</strong> %s</p>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary btn-sm" 
                                data-rowid = %d
                                data-nombre = %s
                                >Editar
                            </button>
                            <button class="btn btn-danger btn-sm"
                                onclick="eliminarTarea(event)"
                                data-rowid = %d
                                data-nombre = %s
                                >Eliminar
                            </button>
                        </div>
                    </div>
                ',
                htmlspecialchars($estadoColorClass, ENT_NOQUOTES, 'UTF-8'),
                htmlspecialchars($this->nombre, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($this->getBadgeColorClass($this->estado), ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($this->estado, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($this->descripcion, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($this->name_user_cargo, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($this->inicio, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($this->final, ENT_QUOTES, 'UTF-8'),
                $this->rowid,
                htmlspecialchars($this->nombre, ENT_QUOTES, 'UTF-8'),
                $this->rowid,
                htmlspecialchars($this->nombre, ENT_QUOTES, 'UTF-8')
            );
            
        }

        /**
         * Determina la clase CSS del color según el estado de la tarea.
         * 
         * @param string $estado Nombre del estado de la tarea.
         * @return string Clase CSS asociada al estado.
         */
        private function getEstadoColorClass($estado): string {
            return match (strtolower($estado)) {
                "activa" => "card-activa",
                "pendiente" => "card-pendiente",
                "finalizada" => "card-finalizada",
                "en_marcha" => "card-en-marcha",
                "cancelada" => "card-cancelada",
                "fallada" => "card-fallada",
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
            return match (strtolower($estado)) {
                "activa" => "bg-primary",                       // Azul
                "pendiente" => "bg-warning text-dark",          // Amarillo
                "finalizada" => "bg-success",                   // Verde
                "en_marcha" => "bg-orange",                     // Naranja  (debes definir esta clase en CSS)
                "cancelada" => "bg-danger",                     // Rojo
                "fallada" => "bg-purple text-light",            // Púrpura (debes definir esta clase en CSS)
                default => "bg-secondary",
            };
        }
    }