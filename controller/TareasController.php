<?php
    namespace Hztpaing\Tareas\controller;
    
    use Hztpaing\Tareas\model\Model_crud;

    class TareasController extends Model_crud {
        protected $table = 'app_tareas';              // Especifica la tabla a usar
        protected $column_id = 'rowid';               // Especifica la columna clave a usar

        public function ListaTareas_usuario($idUser) {
            $query = "
                SELECT 
                    a.rowid,
                    idUser,
                    b.name AS name_user,
                    idUser_cargo,
                    c.name AS name_user_cargo,
                    nombre,
                    descripcion,
                    inicio,
                    final,
                    estadoID,
                    estado
                FROM app_tareas a 
                    JOIN app_users b ON b.rowid = a.idUser
                    JOIN app_users c ON c.rowid = a.idUser_cargo
                WHERE idUser = ?
                ORDER BY a.rowid
            ";
            return $this->execute_prepared_select($query, 'i', [$idUser]);
        }
    }