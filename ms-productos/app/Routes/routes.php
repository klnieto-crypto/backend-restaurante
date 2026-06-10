<?php
// karen: [Rutas ms-productos]
use App\Controllers\CategoriaController;
use App\Controllers\ProductoController;

// Categorias
$app->get('/categorias',         [CategoriaController::class, 'index']);
$app->post('/categorias',        [CategoriaController::class, 'store']);
$app->put('/categorias/{id}',    [CategoriaController::class, 'update']);
$app->delete('/categorias/{id}', [CategoriaController::class, 'destroy']);

// Productos
$app->get('/productos',         [ProductoController::class, 'index']);
$app->get('/productos/{id}',    [ProductoController::class, 'show']);
$app->post('/productos',        [ProductoController::class, 'store']);
$app->put('/productos/{id}',    [ProductoController::class, 'update']);
$app->delete('/productos/{id}', [ProductoController::class, 'destroy']);