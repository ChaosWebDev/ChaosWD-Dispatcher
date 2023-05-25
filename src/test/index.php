<?php
require(__DIR__ . "/../../vendor/autoload.php");

use Order\Dispatcher;

$router = Dispatcher::loadRoutes(__DIR__ . "/routes.php");
$router->dispatcher($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
