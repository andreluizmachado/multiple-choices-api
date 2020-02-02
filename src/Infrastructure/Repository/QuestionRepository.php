<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Repository;

use OAT\MultipleChoiceApi\Domain\Contracts\QuestionRepositoryInterface;
use OAT\MultipleChoiceApi\Domain\Question;
use OAT\MultipleChoiceApi\Domain\QuestionCollection;
use OAT\MultipleChoiceApi\Infrastructure\Database\DataProvider\DataProviderInterface;
use OAT\MultipleChoiceApi\Infrastructure\Repository\Mapper\QuestionMapper;
use Throwable;

class QuestionRepository implements QuestionRepositoryInterface
{
    private DataProviderInterface $statement;
    private QuestionMapper $mapper;

    public function __construct(DataProviderInterface $statement, QuestionMapper $mapper)
    {
        $this->statement = $statement;
        $this->mapper = $mapper;
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(): QuestionCollection
    {
        return $this->mapper->mapArrayToCollection($this->statement->fetchAll());
    }

    /**
     * @inheritDoc
     */
    public function save(Question $question): void
    {
        $this->statement->insert(
            $this->mapper->mapDomainToArray($question)
        );
    }
}