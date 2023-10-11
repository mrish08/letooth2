<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit23d57a33bfd886966e8b2e69f40f0715
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

        spl_autoload_register(array('ComposerAutoloaderInit23d57a33bfd886966e8b2e69f40f0715', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit23d57a33bfd886966e8b2e69f40f0715', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit23d57a33bfd886966e8b2e69f40f0715::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}