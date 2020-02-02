<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Domain;

use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

class QuestionCollection implements IteratorAggregate, JsonSerializable
{
    private array $questions;

    public function __construct(Question ...$questions)
    {
        $this->questions = $questions;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->questions);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return $this->questions;
    }
}