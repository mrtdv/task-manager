<?php
use application\core\Router;

spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});

session_start();
ini_set('display_errors',1);
$path = strtr($_SERVER['PHP_SELF'], array('index.php'=>''));
$router = new Router($path);
$router->run();
$pdo = NULL;
