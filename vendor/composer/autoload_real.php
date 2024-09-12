<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInited1fa3ec3d978ba8125b0aa78e26555f
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

        spl_autoload_register(array('ComposerAutoloaderInited1fa3ec3d978ba8125b0aa78e26555f', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInited1fa3ec3d978ba8125b0aa78e26555f', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInited1fa3ec3d978ba8125b0aa78e26555f::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
