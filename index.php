<?php
// Autoloader
require 'vendor/autoload.php';

$router = new App\Router();

// Define routes
$router->get('/', [new App\Controllers\ListController(), 'index']);
$router->post('/delete', [new App\Controllers\ListController(), 'delete']);
$router->get('/add', [new App\Controllers\AddController(), 'index']);
$router->post('/store', [new App\Controllers\AddController(), 'store']);

$router->dispatch();