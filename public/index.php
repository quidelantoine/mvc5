<?php
date_default_timezone_set('Europe/Paris');
session_start();

if(file_exists('../vendor/autoload.php')) {
    require('../vendor/autoload.php');
}
// Autoloader (namespace)
require('../app/Autoloader.php');
\App\Autoloader::register();
// Instance de PDO
$app = \App\App::getInstance();
// Routes
require('../config/routes.php');
$router = new \App\Weblitzer\Router($routes);

