<?php
// karen: [Controlador mesas]
namespace App\Controllers;

use App\Models\Mesa;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MesaController
{
    public function index(Request $request, Response $response): Response
    {
        $mesas = Mesa::all();
        $response->getBody()->write(json_encode(['data' => $mesas]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $mesa = Mesa::find($args['id']);
        if (!$mesa) {
            $response->getBody()->write(json_encode(['mensaje' => 'Mesa no encontrada']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $response->getBody()->write(json_encode(['data' => $mesa]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();
        $mesa = Mesa::create([
            'numero'    => $body['numero']    ?? 0,
            'capacidad' => $body['capacidad'] ?? 0,
            'estado'    => $body['estado']    ?? 'disponible'
        ]);
        $response->getBody()->write(json_encode(['mensaje' => 'Mesa creada', 'data' => $mesa]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $mesa = Mesa::find($args['id']);
        if (!$mesa) {
            $response->getBody()->write(json_encode(['mensaje' => 'Mesa no encontrada']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $body = $request->getParsedBody();
        $mesa->update([
            'numero'    => $body['numero']    ?? $mesa->numero,
            'capacidad' => $body['capacidad'] ?? $mesa->capacidad,
            'estado'    => $body['estado']    ?? $mesa->estado
        ]);
        $response->getBody()->write(json_encode(['mensaje' => 'Mesa actualizada', 'data' => $mesa]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $mesa = Mesa::find($args['id']);
        if (!$mesa) {
            $response->getBody()->write(json_encode(['mensaje' => 'Mesa no encontrada']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $mesa->delete();
        $response->getBody()->write(json_encode(['mensaje' => 'Mesa eliminada']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}