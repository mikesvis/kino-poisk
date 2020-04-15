<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6f72bb4cb9cff472b47039f8e2ec3d73
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TestParser\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TestParser\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6f72bb4cb9cff472b47039f8e2ec3d73::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6f72bb4cb9cff472b47039f8e2ec3d73::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
