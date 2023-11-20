<?php
require 'vendor/autoload.php';

$router = new App\Router();

// Define routes
$router->get('/', [new App\controllers\ListController(), 'index']);
$router->post('/delete', [new App\controllers\ListController(), 'delete']);
$router->get('/add', [new App\controllers\AddController(), 'index']);
$router->post('/store', [new App\controllers\AddController(), 'store']);

$router->dispatch();