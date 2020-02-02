<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Repository;

use OAT\MultipleChoiceApi\Domain\Contracts\TranslationRepositoryInterface;
use OAT\MultipleChoiceApi\Domain\SearchRequest\TranslationSearchRequest;
use Stichoza\GoogleTranslate\TranslateClient;

class TranslationRepository implements TranslationRepositoryInterface
{
    public const DEFAULT_LANGUAGE = 'en';

    private TranslateClient $client;

    public function __construct(TranslateClient $client)
    {
        $this->client = $client;
    }

    public function first(TranslationSearchRequest $searchRequest): string
    {
        return $this->client->setSource($searchRequest->getSource())
            ->setTarget($searchRequest->getTarget())
            ->translate($searchRequest->getText());
    }
}