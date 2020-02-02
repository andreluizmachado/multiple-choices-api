<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Domain\SearchRequest;

class QuestionSearchRequest
{
    private ?string $language;

    public function __construct(?string $language)
    {
        $this->language = $language;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }
}