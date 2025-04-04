<?php

// Iniciar sesión si no esta iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Pimple\Container;
use Hztpaing\Tareas\src\localization\Translator;
use Hztpaing\Tareas\src\helpers\HtmlHelper;
use Hztpaing\Tareas\src\helpers\ModalHelper;
use Hztpaing\Tareas\src\helpers\ApiHelper;
use Hztpaing\Tareas\controller\TareasController;
use Saludo\Saludo\Saludo;

$container = new Container();

// Determinar idioma dinámicamente desde la sesión, con fallback a APP_LOCALE
$container['locale'] = APP_LOCALE;

// Definir el servicio 'translator' usando el valor dinámico del idioma
$container['translator'] = function ($c) {
    return new Translator($c['locale']);    // Se obtiene el idioma desde el contenedor
};

// Definir el servicio 'htmlHelper'
 $container['htmlHelper'] = function ($c) {
    return new HtmlHelper();
};

// Definir el servicio 'ModalHelper'
$container['modalHelper'] = function ($c) {
    return new ModalHelper();
};

// Definir el servicio 'apiHelper'
$container['apiHelper'] = function ($c) {
    return new ApiHelper();
};

// Definir el servicio 'Saludo'
$container['saludo'] = function ($c) {
    return new Saludo(isset($_SESSION['email']) ? $_SESSION['email'] : 'Invitado');
};

// Definir el servicio 'Model_crud'
 $container['tareasController'] = function ($c) {
    return new TareasController();
};

// Definir otros servicios según sea necesario
// $container['otro_servicio'] = function ($c) {
//     return new OtraClase();
// };

return $container;
