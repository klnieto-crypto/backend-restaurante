<?php
// karen: [Controlador reservas]
namespace App\Controllers;

use App\Models\Reserva;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReservaController
{
    public function index(Request $request, Response $response): Response
    {
        $reservas = Reserva::all();
        $response->getBody()->write(json_encode(['data' => $reservas]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $reserva = Reserva::find($args['id']);
        if (!$reserva) {
            $response->getBody()->write(json_encode(['mensaje' => 'Reserva no encontrada']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $response->getBody()->write(json_encode(['data' => $reserva]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response): Response
    {
        $body    = $request->getParsedBody();
        $reserva = Reserva::create([
            'mesa_id'          => $body['mesa_id']          ?? 0,
            'cliente_nombre'   => $body['cliente_nombre']   ?? '',
            'cliente_telefono' => $body['cliente_telefono'] ?? '',
            'fecha'            => $body['fecha']            ?? '',
            'hora'             => $body['hora']             ?? '',
            'num_personas'     => $body['num_personas']     ?? 1,
            'estado'           => $body['estado']           ?? 'pendiente'
        ]);
        $response->getBody()->write(json_encode(['mensaje' => 'Reserva creada', 'data' => $reserva]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $reserva = Reserva::find($args['id']);
        if (!$reserva) {
            $response->getBody()->write(json_encode(['mensaje' => 'Reserva no encontrada']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $body = $request->getParsedBody();
        $reserva->update($body);
        $response->getBody()->write(json_encode(['mensaje' => 'Reserva actualizada', 'data' => $reserva]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $reserva = Reserva::find($args['id']);
        if (!$reserva) {
            $response->getBody()->write(json_encode(['mensaje' => 'Reserva no encontrada']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $reserva->delete();
        $response->getBody()->write(json_encode(['mensaje' => 'Reserva eliminada']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}