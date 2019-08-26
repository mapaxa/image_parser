<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf55f9a5aebe41d0fcd831b0e72d387b4
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Parser\\Components\\' => 18,
            'Parser\\Classes\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Parser\\Components\\' => 
        array (
            0 => __DIR__ . '/../..' . '/components',
        ),
        'Parser\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Parser\\Classes\\Csv' => __DIR__ . '/../..' . '/classes/Csv.php',
        'Parser\\Classes\\Image' => __DIR__ . '/../..' . '/classes/Image.php',
        'Parser\\Classes\\Page' => __DIR__ . '/../..' . '/classes/Page.php',
        'Parser\\Classes\\Parse' => __DIR__ . '/../..' . '/classes/Parse.php',
        'Parser\\Classes\\ParseController' => __DIR__ . '/../..' . '/classes/ParseController.php',
        'Parser\\Classes\\Tag' => __DIR__ . '/../..' . '/classes/Tag.php',
        'Parser\\Classes\\Url' => __DIR__ . '/../..' . '/classes/Url.php',
        'Parser\\Classes\\UrlPage' => __DIR__ . '/../..' . '/classes/UrlPage.php',
        'Parser\\Components\\Db' => __DIR__ . '/../..' . '/components/Db.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf55f9a5aebe41d0fcd831b0e72d387b4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf55f9a5aebe41d0fcd831b0e72d387b4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf55f9a5aebe41d0fcd831b0e72d387b4::$classMap;

        }, null, ClassLoader::class);
    }
}
