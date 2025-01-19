<?php
require '../vendor/autoload.php';
session_start();

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new app\patternrouter();
$router->route($uri);