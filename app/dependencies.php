<?php declare(strict_types=1);

use OAT\MultipleChoiceApi\Application\Actions\Question\ListQuestionsAction;
use OAT\MultipleChoiceApi\Domain\Contracts\QuestionRepositoryInterface;
use OAT\MultipleChoiceApi\Domain\Contracts\QuestionServiceInterface;
use OAT\MultipleChoiceApi\Domain\Contracts\TranslationRepositoryInterface;
use OAT\MultipleChoiceApi\Infrastructure\Database\Connection\StatementFactory;
use OAT\MultipleChoiceApi\Infrastructure\Database\Connection\StatementInterface;
use OAT\MultipleChoiceApi\Infrastructure\Repository\Mapper\ChoiceMapper;
use OAT\MultipleChoiceApi\Infrastructure\Repository\Mapper\QuestionMapper;
use OAT\MultipleChoiceApi\Infrastructure\Repository\QuestionRepository;
use OAT\MultipleChoiceApi\Infrastructure\Repository\TranslationRepository;
use OAT\MultipleChoiceApi\Infrastructure\Service\QuestionService;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Stichoza\GoogleTranslate\TranslateClient;

return function (App $app) {
    $container = $app->getContainer();

    $container[ListQuestionsAction::class] = function(ContainerInterface $container
    ): ListQuestionsAction {

       return
        new ListQuestionsAction(
            $container[QuestionService::class]
        );
    };

    $container[QuestionService::class] = fn(ContainerInterface $container
    ): QuestionServiceInterface => new QuestionService(
        $container[QuestionRepositoryInterface::class],
        $container[TranslationRepositoryInterface::class]
    );

    $container[QuestionRepositoryInterface::class] = fn(ContainerInterface $container
    ): QuestionRepositoryInterface => new QuestionRepository(
        $container[StatementInterface::class], new QuestionMapper(new ChoiceMapper())
    );

    $container[TranslationRepositoryInterface::class] = fn(ContainerInterface $container
    ): TranslationRepository => new TranslationRepository(
        $container[TranslateClient::class]
    );

    $container[TranslateClient::class] = fn(): TranslateClient => new TranslateClient();

    $container[StatementInterface::class] = fn(): StatementInterface => (new StatementFactory())->make(
        getenv('OAT_MULTIPLE_CHOICE_API_DEFAULT_DATABASE_DSN')
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
