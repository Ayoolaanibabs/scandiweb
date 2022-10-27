<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: Origin, Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
header("HTTP/1.0 200 OK");

include(__DIR__."/core/Application.php");

$app = new Application(dirname(__DIR__));

$app->router->get('/products', [ProductService::class, 'listAll']);
$app->router->post('/products', [ProductService::class, 'add']);
$app->router->post('/products/delete', [ProductService::class, 'massDelete']);

$app->run();
