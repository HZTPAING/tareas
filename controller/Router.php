<?php

namespace Hztpaing\Tareas\controller;

use Hztpaing\Tareas\controller\FiltrarDatos;
use Hztpaing\Tareas\controller\ViewController;
use Hztpaing\Tareas\controller\UserController;

class Router {
    private $route;
    private $requestData;
    private $htmlHelper;
    private $translator;

    public function __construct() {
        global $container;
        $this->htmlHelper = $container['htmlHelper'];
        $this->translator = $container['translator'];

        $filtro = new FiltrarDatos();

        // Unificar $_GET y $_POST, dándole prioridad a los datos de $_POST
        $this->requestData = $filtro->Filtrar(array_merge($_GET, $_POST));

        // Determinar la ruta actual
        $this->route = $this->requestData['r'] ?? 'home';

        // Crear instancia de ViewController
        $controller = new ViewController(BASE_PATH_VIEWS);     // Carga la pagina

        switch ($this->route) {
            // HOME
            case 'home':
                $controller->load_view('home');
                break;
            // LOGIN
            case 'login':
                if(isset($this->requestData['action'])) {
                    // Procesar el formulario de inicio de sesión
                    if ($this->requestData['action'] == 'FORM_LOGIN') {
                        $this->login($this->requestData);
                    }
                    // Procesar el formulario de cierre de sesión
                    if ($this->requestData['action'] == 'FORM_LOGOUT') {
                        $this->logout();
                    }
                } else {
                    if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
                        // Generar el menu y la lista de tareas
                        $controller->load_view('tareas/tareas_navi');
                        $controller->load_view('tareas/tareas_listado');
                        break;
                    } else {
                        // Iniciar el formulario de inicio de la sesion
                        $controller->load_view('navi_log');
                        $controller->load_view('login');
                    }
                }
                break;
            // TAREAS
            case 'tareas':
                // Generar el menu y la lista de tareas
                $controller->load_view('tareas/tareas_navi');
                $controller->load_view('tareas/tareas_listado');
            default:
                $controller->load_view('404');
                break;
        }
    }

    private function login($datos_post) {
        // Iniciar sesión
        $user_controller = new UserController();
        $login_res = $user_controller->ValidarUsuario($datos_post);

        $userExiste = 0;

        if (count($login_res) > 0) {
            $contraseñaFormulario = trim($datos_post['pass']);
            $hashFormulario = md5($contraseñaFormulario);
            if (hash_equals($hashFormulario, $login_res[0]['pass'])) {
                $userExiste = 1;
                session_start();
                $_SESSION['email'] = $login_res[0]['email'];
                $_SESSION['name'] = $login_res[0]['name'];
                $_SESSION['rowid'] = $login_res[0]['rowid'];

                $rol_res = $user_controller->ConsultarRol($login_res[0]['rowid']);
                if ($rol_res) {
                    $_SESSION['rol'] = $rol_res[0]['idrol'];
                    $_SESSION['rol_nombre'] = $rol_res[0]['nombre'];
                }
            } else {
                error_log("Contraseña no coincide. Hash del formulario: $hashFormulario, Hash de BD: {$login_res[0]['pass']}");
            }
        }
        if ($userExiste == 1) {
            header('Location: ' . BASE_URL . DIRECTORY_SEPARATOR . 'index.php?r=tareas');
        } else {
            $resVista = 'login';
            $resCode = 'LOGIN_ERROR';
            $resData = urldecode($datos_post['user']);
            header('Location: ' . BASE_URL . DIRECTORY_SEPARATOR . 'index.php?r=' . $resVista . '&resCode=' . $resCode . '&resData=' . $resData);
        }
    }
    
    private function logout() {
        // Cerrar sesión
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . DIRECTORY_SEPARATOR . 'index.php?r=login');
    }

}

?>