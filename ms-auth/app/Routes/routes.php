<?php
// karen: [Rutas ms-auth]
use App\Controllers\AuthController;

$app->post('/login',    [AuthController::class, 'login']);
$app->post('/registro', [AuthController::class, 'registro']);