<?php
// karen: [Controlador pedidos]
namespace App\Controllers;

use App\Models\Pedido;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PedidoController
{
    public function index(Request $request, Response $response): Response
    {
        $pedidos = Pedido::all();
        $response->getBody()->write(json_encode(['data' => $pedidos]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $pedido = Pedido::find($args['id']);
        if (!$pedido) {
            $response->getBody()->write(json_encode(['mensaje' => 'Pedido no encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $response->getBody()->write(json_encode(['data' => $pedido]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response): Response
    {
        $body   = $request->getParsedBody();
        $pedido = Pedido::create([
            'mesa_id'    => $body['mesa_id']    ?? 0,
            'usuario_id' => $body['usuario_id'] ?? 0,
            'estado'     => $body['estado']     ?? 'pendiente',
            'total'      => $body['total']      ?? 0,
            'fecha'      => $body['fecha']      ?? '',
            'hora'       => $body['hora']       ?? ''
        ]);
        $response->getBody()->write(json_encode(['mensaje' => 'Pedido creado', 'data' => $pedido]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $pedido = Pedido::find($args['id']);
        if (!$pedido) {
            $response->getBody()->write(json_encode(['mensaje' => 'Pedido no encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $body = $request->getParsedBody();
        $pedido->update($body);
        $response->getBody()->write(json_encode(['mensaje' => 'Pedido actualizado', 'data' => $pedido]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $pedido = Pedido::find($args['id']);
        if (!$pedido) {
            $response->getBody()->write(json_encode(['mensaje' => 'Pedido no encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $pedido->delete();
        $response->getBody()->write(json_encode(['mensaje' => 'Pedido eliminado']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}