<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Domain\Contracts;

use OAT\MultipleChoiceApi\Domain\SearchRequest\TranslationSearchRequest;

interface TranslationRepositoryInterface
{
    public function first(TranslationSearchRequest $searchRequest): string;
}