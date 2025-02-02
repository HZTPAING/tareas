<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Pimple\Container;
use Hztpaing\Tareas\localization\Translator;
use Hztpaing\Tareas\src\helpers\HtmlHelper;
use Saludo\Saludo\Saludo;

$container = new Container();

// Definir el servicio 'translator'
$container['translator'] = function ($c) {
    return new Translator(APP_LOCALE);
};

// Definir el servicio 'htmlHelper'
 $container['htmlHelper'] = function ($c) {
    return new HtmlHelper();
};

// Definir el servicio 'Saludo'
$container['saludo'] = function ($c) {
    return new Saludo(isset($_SESSION['email']) ? $_SESSION['email'] : 'Invitado');
};

// Definir otros servicios según sea necesario
// $container['otro_servicio'] = function ($c) {
//     return new OtraClase();
// };

return $container;
