<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Domain;

use JsonSerializable;

class Choice implements JsonSerializable
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
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
        ];
    }
}