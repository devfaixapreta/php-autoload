<?php

function psr4Autoload() {
    return [
        'App\\' => [''],
        'App\Lib\\' => ['lib/', 'vendor/']
    ];
}

function appAutoload($Class) {
    $classDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    $prefix_path = psr4Autoload();
    $pos = strrpos($Class, '\\');
    if ($pos != false) {
        $prefix = substr($Class, 0, $pos + 1);
        $relative_class = substr($Class, $pos + 1);
        if (!isset($prefix_path[$prefix])) {
            throw new Exception("Error: Classe \"$Class\" não encontrada!");
        }
        foreach ($prefix_path[$prefix] as $base) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $classDir . $base . $relative_class . '.php');
            if (file_exists($file)) {
                break;
            }
        }
    } else {
        $file = str_replace("\\", DIRECTORY_SEPARATOR, $classDir . "{$Class}.php");
    }
    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception("Error: Classe \"$Class\" não encontrada!");
    }
}

spl_autoload_register('appAutoload');
