<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Application\Actions\Question;

use DateTimeImmutable;
use OAT\MultipleChoiceApi\Domain\Choice;
use OAT\MultipleChoiceApi\Domain\ChoiceCollection;
use OAT\MultipleChoiceApi\Domain\Contracts\QuestionServiceInterface;
use OAT\MultipleChoiceApi\Domain\Question;
use Slim\Http\Request;
use Slim\Http\Response;

class SaveQuestionAction
{
    private QuestionServiceInterface $service;

    public function __construct(QuestionServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        $body = $request->getParsedBody();

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->service->save(
            new Question(
                $body['text'],
                new DateTimeImmutable($body['createdAt']),
                new ChoiceCollection(
                    ...array_map(
                           function (array $choice): Choice {
                               return new Choice($choice['text']);
                           },
                           $body['choices']
                       )
                )
            )
        );

        return new Response();
    }
}