<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2a1f409bc52ac2f2e0674223f3043bbb
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'VK\\' => 3,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'VK\\' => 
        array (
            0 => __DIR__ . '/..' . '/vkcom/vk-php-sdk/src/VK',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2a1f409bc52ac2f2e0674223f3043bbb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2a1f409bc52ac2f2e0674223f3043bbb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2a1f409bc52ac2f2e0674223f3043bbb::$classMap;

        }, null, ClassLoader::class);
    }
}