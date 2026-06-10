<?php
// karen: [Rutas ms-pedidos]
use App\Controllers\PedidoController;
use App\Controllers\DetallePedidoController;

// Pedidos
$app->get('/pedidos',         [PedidoController::class, 'index']);
$app->get('/pedidos/{id}',    [PedidoController::class, 'show']);
$app->post('/pedidos',        [PedidoController::class, 'store']);
$app->put('/pedidos/{id}',    [PedidoController::class, 'update']);
$app->delete('/pedidos/{id}', [PedidoController::class, 'destroy']);

// Detalles
$app->get('/pedidos/{id}/detalles',  [DetallePedidoController::class, 'index']);
$app->post('/pedidos/{id}/detalles', [DetallePedidoController::class, 'store']);
$app->delete('/detalles/{id}',       [DetallePedidoController::class, 'destroy']);