<?php
// karen: [Controlador autenticación]
namespace App\Controllers;

use App\Models\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    public function login(Request $request, Response $response): Response
    {
        $body     = $request->getParsedBody();
        $email    = $body['email'] ?? '';
        $password = $body['password'] ?? '';

        $usuario = Usuario::where('email', $email)
                          ->where('password', md5($password))
                          ->first();

        if (!$usuario) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'Credenciales incorrectas'
            ]));
            return $response->withHeader('Content-Type', 'application/json')
                            ->withStatus(401);
        }

        $token = base64_encode($usuario->id . ':' . $usuario->email . ':' . time());

        $response->getBody()->write(json_encode([
            'token'   => $token,
            'usuario' => $usuario
        ]));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    }

    public function registro(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();

        $usuario = Usuario::create([
            'nombre'   => $body['nombre']   ?? '',
            'email'    => $body['email']    ?? '',
            'password' => md5($body['password'] ?? ''),
            'rol'      => $body['rol']      ?? 'empleado'
        ]);

        $response->getBody()->write(json_encode([
            'mensaje' => 'Usuario creado',
            'data'    => $usuario
        ]));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(201);
    }
}