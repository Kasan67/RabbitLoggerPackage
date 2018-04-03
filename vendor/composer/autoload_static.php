<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8cf9e3c18320df28f869cbb9585761aa
{
    public static $prefixLengthsPsr4 = array (
        'k' => 
        array (
            'kashirin\\rabbit_mq\\' => 19,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'PhpAmqpLib\\' => 11,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'kashirin\\rabbit_mq\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PhpAmqpLib\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-amqplib/php-amqplib/PhpAmqpLib',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8cf9e3c18320df28f869cbb9585761aa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8cf9e3c18320df28f869cbb9585761aa::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
