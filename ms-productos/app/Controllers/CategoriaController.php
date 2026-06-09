<?php
// karen: [Controlador categorias]
namespace App\Controllers;

use App\Models\Categoria;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoriaController
{
    public function index(Request $request, Response $response): Response
    {
        $categorias = Categoria::all();
        $response->getBody()->write(json_encode(['data' => $categorias]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response): Response
    {
        $body      = $request->getParsedBody();
        $categoria = Categoria::create([
            'nombre'      => $body['nombre']      ?? '',
            'descripcion' => $body['descripcion'] ?? ''
        ]);
        $response->getBody()->write(json_encode(['mensaje' => 'Categoría creada', 'data' => $categoria]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $categoria = Categoria::find($args['id']);
        if (!$categoria) {
            $response->getBody()->write(json_encode(['mensaje' => 'Categoría no encontrada']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $body = $request->getParsedBody();
        $categoria->update($body);
        $response->getBody()->write(json_encode(['mensaje' => 'Categoría actualizada', 'data' => $categoria]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $categoria = Categoria::find($args['id']);
        if (!$categoria) {
            $response->getBody()->write(json_encode(['mensaje' => 'Categoría no encontrada']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $categoria->delete();
        $response->getBody()->write(json_encode(['mensaje' => 'Categoría eliminada']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}