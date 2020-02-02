<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Domain;

use ArrayIterator;
use Iterator;
use IteratorAggregate;
use JsonSerializable;

class ChoiceCollection implements IteratorAggregate, JsonSerializable
{
    private array $choices;

    public function __construct(Choice ...$choices)
    {
        $this->choices = $choices;
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->choices);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return $this->choices;
    }
}