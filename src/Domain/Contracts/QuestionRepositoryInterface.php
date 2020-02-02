<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Domain\Contracts;

use OAT\MultipleChoiceApi\Domain\Question;
use OAT\MultipleChoiceApi\Domain\QuestionCollection;
use Throwable;

interface QuestionRepositoryInterface
{
    /**
     * @return QuestionCollection
     *
     * @throws Throwable
     */
    public function fetchAll(): QuestionCollection;

    /**
     * @param Question $question
     *
     * @throws Throwable
     */
    public function save(Question $question): void  ;
}