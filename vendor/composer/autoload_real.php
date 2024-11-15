<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit84fb0eb104a9c8092ec503b5fc33f51c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit84fb0eb104a9c8092ec503b5fc33f51c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit84fb0eb104a9c8092ec503b5fc33f51c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit84fb0eb104a9c8092ec503b5fc33f51c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
