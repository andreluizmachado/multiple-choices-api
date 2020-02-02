<?php declare(strict_types=1);

use OAT\MultipleChoiceApi\Application\Actions\Question\ListQuestionsAction;
use OAT\MultipleChoiceApi\Application\Actions\Question\SaveQuestionAction;
use OAT\MultipleChoiceApi\Application\Middleware\RequestValidatorMiddleware;
use OAT\MultipleChoiceApi\Application\Middleware\ResponseFormatterMiddleware;
use Slim\App;

return function (App $app): void {
    $app->group(
        '/questions',
        function (App $app) {
            $app->get('', ListQuestionsAction::class)
                ->add(RequestValidatorMiddleware::class . '::QuestionSearchRequest')
                ->add(ResponseFormatterMiddleware::class);
            $app->post('', SaveQuestionAction::class)
                ->add(RequestValidatorMiddleware::class . '::Question');
        }
    );
};
