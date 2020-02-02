<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ResponseFormatterMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next): ResponseInterface
    {
        /** @var Response $response */
        $response = $next($request, $response);
        return $response->withJson(
            ['data' => json_decode((string)$response->getBody(), true)]
        );
    }
}