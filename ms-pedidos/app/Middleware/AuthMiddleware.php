<?php
// karen: [Middleware autenticación ms-pedidos]
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, Handler $handler): Response
    {
        $token = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);

        if (empty($token)) {
            $response = new \Nyholm\Psr7\Response();
            $response->getBody()->write(json_encode(['mensaje' => 'Token requerido']));
            return $response->withHeader('Content-Type', 'application/json')
                            ->withStatus(401);
        }

        return $handler->handle($request);
    }
}