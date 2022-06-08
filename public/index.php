<?php

use Frisbee\core\Router;

error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($class) {
    $prefix = 'Frisbee\\';
    $GLOBALS['base_dir'] = __DIR__ . '/../application/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $GLOBALS['base_dir'] . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});


if (!isset($_SERVER["REDIRECT_URL"])) {
    Router::execute('/');
} else {
    Router::execute($_SERVER["REDIRECT_URL"]);
}



