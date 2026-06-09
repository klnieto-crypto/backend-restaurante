<?php
// karen: [Controlador productos]
namespace App\Controllers;

use App\Models\Producto;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductoController
{
    public function index(Request $request, Response $response): Response
    {
        $productos = Producto::all();
        $response->getBody()->write(json_encode(['data' => $productos]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $producto = Producto::find($args['id']);
        if (!$producto) {
            $response->getBody()->write(json_encode(['mensaje' => 'Producto no encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $response->getBody()->write(json_encode(['data' => $producto]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response): Response
    {
        $body     = $request->getParsedBody();
        $producto = Producto::create([
            'categoria_id' => $body['categoria_id'] ?? 0,
            'nombre'       => $body['nombre']       ?? '',
            'descripcion'  => $body['descripcion']  ?? '',
            'precio'       => $body['precio']       ?? 0,
            'disponible'   => $body['disponible']   ?? 1
        ]);
        $response->getBody()->write(json_encode(['mensaje' => 'Producto creado', 'data' => $producto]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $producto = Producto::find($args['id']);
        if (!$producto) {
            $response->getBody()->write(json_encode(['mensaje' => 'Producto no encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $body = $request->getParsedBody();
        $producto->update($body);
        $response->getBody()->write(json_encode(['mensaje' => 'Producto actualizado', 'data' => $producto]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $producto = Producto::find($args['id']);
        if (!$producto) {
            $response->getBody()->write(json_encode(['mensaje' => 'Producto no encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $producto->delete();
        $response->getBody()->write(json_encode(['mensaje' => 'Producto eliminado']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}