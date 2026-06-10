<?php
// karen: [Rutas ms-reservas]
use App\Controllers\MesaController;
use App\Controllers\ReservaController;

// Mesas
$app->get('/mesas',          [MesaController::class, 'index']);
$app->get('/mesas/{id}',     [MesaController::class, 'show']);
$app->post('/mesas',         [MesaController::class, 'store']);
$app->put('/mesas/{id}',     [MesaController::class, 'update']);
$app->delete('/mesas/{id}',  [MesaController::class, 'destroy']);

// Reservas
$app->get('/reservas',         [ReservaController::class, 'index']);
$app->get('/reservas/{id}',    [ReservaController::class, 'show']);
$app->post('/reservas',        [ReservaController::class, 'store']);
$app->put('/reservas/{id}',    [ReservaController::class, 'update']);
$app->delete('/reservas/{id}', [ReservaController::class, 'destroy']);