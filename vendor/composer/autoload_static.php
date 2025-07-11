<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit34967542735206d72f0eae95e904f0a3
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\WebServes\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\WebServes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/WebServes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit34967542735206d72f0eae95e904f0a3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit34967542735206d72f0eae95e904f0a3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit34967542735206d72f0eae95e904f0a3::$classMap;

        }, null, ClassLoader::class);
    }
}
