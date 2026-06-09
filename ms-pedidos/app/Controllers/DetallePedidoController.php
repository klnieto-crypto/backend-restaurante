<?php
// karen: [Controlador detalles pedido]
namespace App\Controllers;

use App\Models\DetallePedido;
use App\Models\Pedido;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DetallePedidoController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        $detalles = DetallePedido::where('pedido_id', $args['id'])->get();
        $response->getBody()->write(json_encode(['data' => $detalles]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        $body    = $request->getParsedBody();
        $detalle = DetallePedido::create([
            'pedido_id'      => $args['id'],
            'producto_id'    => $body['producto_id']    ?? 0,
            'cantidad'       => $body['cantidad']       ?? 1,
            'precio_unitario'=> $body['precio_unitario']?? 0,
            'subtotal'       => $body['subtotal']       ?? 0
        ]);

        // Actualizar total del pedido
        $total = DetallePedido::where('pedido_id', $args['id'])->sum('subtotal');
        Pedido::find($args['id'])->update(['total' => $total]);

        $response->getBody()->write(json_encode(['mensaje' => 'Detalle agregado', 'data' => $detalle]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function destroy(Request $request, Response $response, array $args): Response
    {
        $detalle = DetallePedido::find($args['id']);
        if (!$detalle) {
            $response->getBody()->write(json_encode(['mensaje' => 'Detalle no encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
        $pedidoId = $detalle->pedido_id;
        $detalle->delete();

        // Actualizar total del pedido
        $total = DetallePedido::where('pedido_id', $pedidoId)->sum('subtotal');
        Pedido::find($pedidoId)->update(['total' => $total]);

        $response->getBody()->write(json_encode(['mensaje' => 'Detalle eliminado']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}