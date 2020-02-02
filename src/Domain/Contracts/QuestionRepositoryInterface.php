<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Domain\Contracts;

use OAT\MultipleChoiceApi\Domain\QuestionCollection;

interface QuestionRepositoryInterface
{
    public function fetchAll(): QuestionCollection;
}