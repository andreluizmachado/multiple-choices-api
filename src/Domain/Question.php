<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Domain;

use DateTimeInterface;
use JsonSerializable;

class Question implements JsonSerializable
{
    private string $text;

    private DateTimeInterface $createdAt;

    private ChoiceCollection $choiceCollection;

    public function __construct(string $text, DateTimeInterface $createdAt, ChoiceCollection $choiceCollection)
    {
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->choiceCollection = $choiceCollection;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getChoiceCollection(): ChoiceCollection
    {
        return $this->choiceCollection;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'text' => $this->text,
            'createdAt' => $this->createdAt->format(DATE_ATOM),
            'choices' => $this->choiceCollection
        ];
    }
}