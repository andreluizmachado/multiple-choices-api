<?php declare(strict_types=1);

use OAT\MultipleChoiceApi\Application\Actions\Question\ListQuestionsAction;
use OAT\MultipleChoiceApi\Infrastructure\Repository\QuestionRepository;
use OAT\MultipleChoiceApi\Infrastructure\Service\QuestionService;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    $container[ListQuestionsAction::class] = fn(): ListQuestionsAction => new ListQuestionsAction(
        new QuestionService(
            new QuestionRepository()
        ),
    );

    // monolog
    $container['logger'] = function (ContainerInterface $container): LoggerInterface {
        $settings = $container->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };
};
