<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9e51592a6e5a378eb9d41c0b664a4c14
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Blue\\Saber\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Blue\\Saber\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9e51592a6e5a378eb9d41c0b664a4c14::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9e51592a6e5a378eb9d41c0b664a4c14::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
