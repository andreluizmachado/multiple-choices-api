<?php declare(strict_types=1);

use OAT\MultipleChoiceApi\Application\Actions\Question\ListQuestionsAction;
use OAT\MultipleChoiceApi\Application\Actions\Question\SaveQuestionAction;
use Slim\App;

return function (App $app): void {
    $container = $app->getContainer();

    $app->group(
        '/questions',
        function (App $app) {
            $app->get('', ListQuestionsAction::class);
            $app->post('', SaveQuestionAction::class);
        }
    );
};
