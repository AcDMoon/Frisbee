<?php

use Applications\Core\Router;

spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path)){
        require $path;
    }
});




Router::execute($_SERVER["REDIRECT_URL"])
?>