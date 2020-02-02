<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Domain\SearchRequest;

class TranslationSearchRequest
{
    private string $source;

    private string $target;

    private string $text;

    public function __construct(string $source, string $target, string $text)
    {
        $this->source = $source;
        $this->target = $target;
        $this->text = $text;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function getText(): string
    {
        return $this->text;
    }
}