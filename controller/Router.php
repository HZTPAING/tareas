<?php

namespace Hztpaing\Tareas\controller;

use Hztpaing\Tareas\controller\FiltrarDatos;
use Hztpaing\Tareas\controller\ViewController;
use Hztpaing\Tareas\controller\UserController;
use Exception;

class Router {
    private $route;
    private $requestData;
    private $htmlHelper;
    private $apiHelper;
    private $translator;
    private $tareasController;

    public function __construct() {
        global $container;
        $this->htmlHelper = $container['htmlHelper'];
        $this->apiHelper = $container['apiHelper'];
        $this->translator = $container['translator'];
        $this->tareasController = $container['tareasController'];

        $filtro = new FiltrarDatos();

        // Unificar $_GET y $_POST, dándole prioridad a los datos de $_POST
        $this->requestData = $filtro->Filtrar(array_merge($_GET, $_POST));

        // Determinar la ruta actual
        $this->route = $this->requestData['r'] ?? 'home';

        // Crear instancia de ViewController
        $controller = new ViewController(BASE_PATH_VIEWS);     // Carga la pagina

        switch ($this->route) {
            // Establecer idioma por defecto y permitir cambiarlo
            case 'change_locale':
                if (isset($this->requestData['locale'])) {
                    $_SESSION['locale'] = $this->requestData['locale'];
                }
                header('Location: '. BASE_URL . DIRECTORY_SEPARATOR . 'index.php?r='. $this->requestData['route_previous'] ?? 'home');
                exit();
                break;
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
                        $this->load_tareas($controller);
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
                if (isset($this->requestData['action']) && !empty($this->requestData['action'])) {
                    switch ($this->requestData['action']) {
                        // Crear nueva tarea
                        case 'FORM_NUEVA_TAREA':
                            $this->tareasController->CrearTarea($this->requestData);
                            break;
                        // Editar tarea
                        case 'FORM_EDITAR_TAREA':
                            $this->tareasController->ActualizarTarea($this->requestData);
                            break;
                        // Eliminar tarea
                        case 'AJAX_ELIMINAR_TAREA':
                            $this->eliminar_tarea($this->requestData);
                            break;
                    }
                } else {
                    // Generar el menu y la lista de tareas
                    $this->load_tareas($controller);
                }
                break;
            // API_TRANSLATIONS
            case 'api_tranlations':
                // Obtener traducciones
                $this->apiHelper->handleApiTranslations();
                break;
            // ADICIONAL
            case 'adicional':
                // Procesar la acción de consultar la lista de los usuarios
                if ($this->requestData['action'] == 'AJAX_LISTA_USUARIOS') {
                    $this->listaUsuarios($this->requestData['idUser_cargo']);
                }
                break;
            default:
                $controller->load_view('404');
                break;
        }
    }

    private function eliminar_tarea($datos) {
        // Eliminar la tarea de la base de datos
        try {
            // Eliminar la tarea de la base de datos
            $this->tareasController->delete($datos['rowId'], 'i');
            echo json_encode([
                'success' => true,
                'msg' => $datos['nombreTarea']
            ]);
        } catch (Exception $e) {
            // En caso de error, enviar el mensaje de error
            echo json_encode([
                'success' => false,
                'msg' => $datos['nombreTarea']
            ]);
        }
    }

    private function listaUsuarios($idUser_cargo) {
        $user_controller = new UserController();
        try {
            $datos_usuarios = $user_controller->ListaUsuario($idUser_cargo);
            echo json_encode([
                'success' => true,
                'datos_usuarios' => $datos_usuarios
            ]);
        } catch (Exception $e) {
            // En caso de error, enviar el mensaje de error
            echo json_encode([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }

    }

    private function load_tareas($controller) {
        // Generar el menu y la lista de tareas
        $controller->load_view('tareas/tareas_navi', [
            'datos_route' => 'tareas'
        ]);
        // Consultar los datos de las tareas en la base de datos
        $datosTareas_user = $this->tareasController->ListaTareas_usuario($_SESSION['rowid']);
        $controller->load_view('tareas/tareas_listado', [
            'datosTareas_user' => $datosTareas_user
        ]);
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

                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                $_SESSION['locale'] = APP_LOCALE;
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
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        // Recuperamos el idioma de la sesion cerrada
        session_start();
        $_SESSION['locale'] = APP_LOCALE;
        header('Location: ' . BASE_URL . DIRECTORY_SEPARATOR . 'index.php?r=login');
    }

}

?>