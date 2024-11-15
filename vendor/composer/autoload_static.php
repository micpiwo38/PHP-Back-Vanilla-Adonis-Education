<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit84fb0eb104a9c8092ec503b5fc33f51c
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' => 
        array (
            'Micpi\\MicOffice\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Micpi\\MicOffice\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit84fb0eb104a9c8092ec503b5fc33f51c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit84fb0eb104a9c8092ec503b5fc33f51c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit84fb0eb104a9c8092ec503b5fc33f51c::$classMap;

        }, null, ClassLoader::class);
    }
}
