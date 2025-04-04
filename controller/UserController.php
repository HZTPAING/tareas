<?php
    namespace Hztpaing\Tareas\controller;
    
    use Hztpaing\Tareas\model\Model_crud;

    class UserController extends Model_crud {
        public function ListaUsuario($idUser = null) {
            $query = "SELECT rowid, name, email, status, 
                    CASE WHEN rowid = ? THEN true ELSE false END AS is_selected 
                FROM app_users WHERE status = 2";

            return $this->execute_prepared_select($query, 'i', [$idUser]);
        }

        public function ValidarUsuario($datos) {
            $query = "SELECT * FROM app_users WHERE status = 2 AND email = ?";

            return $this->execute_prepared_select($query, 's', [$datos['user']]);
        }

        public function ConsultarRol($rowid) {
            $query = "SELECT a.idrol, b.nombre FROM app_users_rol a, app_rol b WHERE a.idrol = b.rowid AND a.iduser = ?";
            
            return $this->execute_prepared_select($query, 'i', [$rowid]);
        }
    }