<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Repository;

use OAT\MultipleChoiceApi\Domain\Contracts\QuestionRepositoryInterface;
use OAT\MultipleChoiceApi\Domain\QuestionCollection;
use OAT\MultipleChoiceApi\Infrastructure\Database\Connection\StatementInterface;
use OAT\MultipleChoiceApi\Infrastructure\Repository\Mapper\QuestionMapper;
use Throwable;

class QuestionRepository implements QuestionRepositoryInterface
{
    private StatementInterface $statement;
    private QuestionMapper $mapper;

    public function __construct(StatementInterface $statement, QuestionMapper $mapper)
    {
        $this->statement = $statement;
        $this->mapper = $mapper;
    }

    /**
     * @return QuestionCollection
     *
     * @throws Throwable
     */
    public function fetchAll(): QuestionCollection
    {
        return $this->mapper->mapCollection($this->statement->fetchAll());
    }
}