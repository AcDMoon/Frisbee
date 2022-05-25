<?php

use application\core\Router;

error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});


if (!isset($_SERVER["REDIRECT_URL"])) {
    Router::execute('/');
} else {
    Router::execute($_SERVER["REDIRECT_URL"]);
}
