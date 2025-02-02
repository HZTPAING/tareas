<?php
    namespace Hztpaing\Tareas\controller;
    
    use Hztpaing\Tareas\model\Model_crud;

    class UserController extends Model_crud {
        protected $_table_name = 'app_users';
        protected $_id = 'rowid';

        public function ValidarUsuario($datos) {
            $query = "SELECT * FROM app_users WHERE status = 2 AND email = ?";

            return $this->execute_prepared_select($query, 's', [$datos['user']]);
        }

        public function ConsultarRol($rowid) {
            $query = "SELECT a.idrol, b.nombre FROM app_users_rol a, app_rol b WHERE a.idrol = b.rowid AND a.iduser = ?";
            
            return $this->execute_prepared_select($query, 'i', [$rowid]);
        }
    }