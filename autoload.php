<?php

function appAutoload($Class) {
    $prefix_path = [
        'App\Class\\' => ['classes'],
        'App\Lib\\' => ['classes/lib']
    ];

    $dir =  __DIR__ . '/';
    $file = str_replace("\\", '/', $dir . "classes/{$Class}.php");

    if (file_exists($file)) {
        require_once $file;
    } else {
        //Psr4 - Autoload
        $pos = strrpos($Class, '\\');
        $prefix = substr($Class, 0, $pos + 1);
        $relative_class = substr($Class, $pos + 1);

        if (!isset($prefix_path[$prefix])) {
            throw new Exception("Error: Classe \"$Class\" não encontrada!");
        }

        foreach ($prefix_path[$prefix] as $base) {
            $file = str_replace('\\', '/', $dir . $base . '/' . $relative_class) . '.php';

            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
}

spl_autoload_register('appAutoload');

