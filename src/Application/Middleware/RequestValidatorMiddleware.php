<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Application\Middleware;

use OAT\MultipleChoiceApi\Application\RequestValidators\BadRequestException;
use OAT\MultipleChoiceApi\Application\RequestValidators\QuestionRequestValidator;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

class RequestValidatorMiddleware
{
    private QuestionRequestValidator $validator;

    public function __construct(QuestionRequestValidator $validator)
    {
        $this->validator = $validator;
    }

    public function __invoke(Request $request, Response $response, callable $next): ResponseInterface
    {
        try {
            $this->validator->validate($request);
        } catch (BadRequestException $exception) {
            return $response->withStatus(StatusCode::HTTP_BAD_REQUEST)
                ->withJson(
                    [
                        'error' => $exception->getMessage()
                    ]
                );
        }
        return $next($request, $response);
    }
}