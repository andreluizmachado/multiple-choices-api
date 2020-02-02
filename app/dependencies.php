<?php declare(strict_types=1);

use JsonSchema\Validator;
use OAT\MultipleChoiceApi\Application\Actions\Question\ListQuestionsAction;
use OAT\MultipleChoiceApi\Application\Actions\Question\SaveQuestionAction;
use OAT\MultipleChoiceApi\Application\Middleware\RequestValidatorMiddleware;
use OAT\MultipleChoiceApi\Application\RequestValidators\QuestionRequestValidator;
use OAT\MultipleChoiceApi\Domain\Contracts\QuestionRepositoryInterface;
use OAT\MultipleChoiceApi\Domain\Contracts\QuestionServiceInterface;
use OAT\MultipleChoiceApi\Domain\Contracts\TranslationRepositoryInterface;
use OAT\MultipleChoiceApi\Infrastructure\Database\DataProvider\DataProviderFactory;
use OAT\MultipleChoiceApi\Infrastructure\Database\DataProvider\DataProviderInterface;
use OAT\MultipleChoiceApi\Infrastructure\Repository\Mapper\ChoiceMapper;
use OAT\MultipleChoiceApi\Infrastructure\Repository\Mapper\QuestionMapper;
use OAT\MultipleChoiceApi\Infrastructure\Repository\QuestionRepository;
use OAT\MultipleChoiceApi\Infrastructure\Repository\TranslationRepository;
use OAT\MultipleChoiceApi\Infrastructure\Service\QuestionService;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Stichoza\GoogleTranslate\GoogleTranslate;

return function (App $app): void {
    $questionSearchRequestValidatorMiddleware = RequestValidatorMiddleware::class . '::QuestionSearchRequest';
    $questionValidatorMiddleware = RequestValidatorMiddleware::class . '::Question';

    $container = $app->getContainer();

    $container[ListQuestionsAction::class] = fn(ContainerInterface $container
    ): ListQuestionsAction => new ListQuestionsAction(
        $container[QuestionService::class]
    );

    $container[SaveQuestionAction::class] = fn(ContainerInterface $container
    ): SaveQuestionAction => new SaveQuestionAction(
        $container[QuestionService::class]
    );

    $container[$questionSearchRequestValidatorMiddleware] = function(ContainerInterface $container
    ): RequestValidatorMiddleware {
        return new RequestValidatorMiddleware(
            new QuestionRequestValidator(
                new Validator(),
                $container['settings']['schemas']['questionSearchRequest']
            )
        );
    };

    $container[$questionValidatorMiddleware] = fn(ContainerInterface $container
    ): RequestValidatorMiddleware => new RequestValidatorMiddleware(
        new QuestionRequestValidator(
            new Validator(),
            $container['settings']['schemas']['question']
        )
    );

    $container[QuestionService::class] = fn(ContainerInterface $container
    ): QuestionServiceInterface => new QuestionService(
        $container[QuestionRepositoryInterface::class],
        $container[TranslationRepositoryInterface::class]
    );

    $container[QuestionRepositoryInterface::class] = fn(ContainerInterface $container
    ): QuestionRepositoryInterface => new QuestionRepository(
        $container[DataProviderInterface::class], new QuestionMapper(new ChoiceMapper())
    );

    $container[TranslationRepositoryInterface::class] = fn(ContainerInterface $container
    ): TranslationRepository => new TranslationRepository(
        $container[GoogleTranslate::class]
    );

    $container[GoogleTranslate::class] = fn(): GoogleTranslate => new GoogleTranslate();

    $container[DataProviderInterface::class] = fn(): DataProviderInterface => (new DataProviderFactory())->make(
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
