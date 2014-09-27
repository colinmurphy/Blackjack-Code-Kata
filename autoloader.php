<?php

// Set Constants
define('DS', DIRECTORY_SEPARATOR);
define('APP_DIR', __DIR__ . DS . 'app' . DS);


function autoloader($class)
{
    // App Directory
    $file = APP_DIR . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }

}
spl_autoload_register('autoloader');