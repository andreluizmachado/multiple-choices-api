<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Repository\Mapper;

use OAT\MultipleChoiceApi\Domain\Choice;
use OAT\MultipleChoiceApi\Domain\ChoiceCollection;

class ChoiceMapper
{
    public function map(array $data): Choice
    {
        return new Choice($data['text']);
    }

    public function mapCollection(array $data): ChoiceCollection
    {
        return new ChoiceCollection(...array_map([$this, 'map'], $data));
    }
}