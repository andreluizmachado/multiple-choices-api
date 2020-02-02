<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Domain\Contracts;

use OAT\MultipleChoiceApi\Domain\QuestionCollection;
use OAT\MultipleChoiceApi\Domain\SearchRequest\QuestionSearchRequest;

interface QuestionServiceInterface
{
    public function find(QuestionSearchRequest $searchRequest): QuestionCollection;

}