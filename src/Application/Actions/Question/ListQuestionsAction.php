<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Application\Actions\Question;

use OAT\MultipleChoiceApi\Domain\Contracts\QuestionServiceInterface;
use OAT\MultipleChoiceApi\Domain\SearchRequest\QuestionSearchRequest;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ListQuestionsAction
{
    private QuestionServiceInterface $service;

    public function __construct(QuestionServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): ResponseInterface
    {
        return (new Response())
            ->withJson(
                $this->service->find(
                    new QuestionSearchRequest(
                        $request->getQueryParam('lang')
                    )
                )
            );
    }
}