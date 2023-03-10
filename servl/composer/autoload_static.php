<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitce97cb74aee7e693c1194a9a9b509a69
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitce97cb74aee7e693c1194a9a9b509a69::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitce97cb74aee7e693c1194a9a9b509a69::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitce97cb74aee7e693c1194a9a9b509a69::$classMap;

        }, null, ClassLoader::class);
    }
}
