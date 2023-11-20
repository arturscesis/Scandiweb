<?php
require 'vendor/autoload.php';

$router = new App\Router();

// Define routes
$router->get('/scanditest/', [new App\Controllers\ListController(), 'index']);
$router->post('/scanditest/delete', [new App\Controllers\ListController(), 'delete']);
$router->get('/scanditest/add', [new App\Controllers\AddController(), 'index']);
$router->post('/scanditest/store', [new App\Controllers\AddController(), 'store']);

$router->dispatch();