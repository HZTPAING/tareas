<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit92a129ffb24b3f698d3a7dcbe5003060
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Saludo\\' => 7,
        ),
        'P' => 
        array (
            'Psr\\Container\\' => 14,
            'PhpOption\\' => 10,
        ),
        'H' => 
        array (
            'Hztpaing\\Tareas\\src\\tareas\\' => 27,
            'Hztpaing\\Tareas\\src\\localization\\' => 33,
            'Hztpaing\\Tareas\\src\\helpers\\' => 28,
            'Hztpaing\\Tareas\\model\\' => 22,
            'Hztpaing\\Tareas\\controller\\' => 27,
            'Hztpaing\\Tareas\\' => 16,
        ),
        'G' => 
        array (
            'GrahamCampbell\\ResultType\\' => 26,
        ),
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Saludo\\' => 
        array (
            0 => __DIR__ . '/..' . '/hztpaserg/saludo/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'PhpOption\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoption/phpoption/src/PhpOption',
        ),
        'Hztpaing\\Tareas\\src\\tareas\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/tareas',
        ),
        'Hztpaing\\Tareas\\src\\localization\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/localization',
        ),
        'Hztpaing\\Tareas\\src\\helpers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/helpers',
        ),
        'Hztpaing\\Tareas\\model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/model',
        ),
        'Hztpaing\\Tareas\\controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controller',
        ),
        'Hztpaing\\Tareas\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'GrahamCampbell\\ResultType\\' => 
        array (
            0 => __DIR__ . '/..' . '/graham-campbell/result-type/src',
        ),
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static $classMap = array (
        'Attribute' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Attribute.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'PhpToken' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/PhpToken.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit92a129ffb24b3f698d3a7dcbe5003060::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit92a129ffb24b3f698d3a7dcbe5003060::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit92a129ffb24b3f698d3a7dcbe5003060::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit92a129ffb24b3f698d3a7dcbe5003060::$classMap;

        }, null, ClassLoader::class);
    }
}
