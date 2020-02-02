<?php declare(strict_types=1);

use OAT\MultipleChoiceApi\Application\Actions\Question\ListQuestionsAction;
use Slim\App;

return function (App $app): void {
    $container = $app->getContainer();

    $app->get('/questions', ListQuestionsAction::class);
};
