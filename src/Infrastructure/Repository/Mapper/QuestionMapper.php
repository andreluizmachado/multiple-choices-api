<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Repository\Mapper;

use DateTimeImmutable;
use OAT\MultipleChoiceApi\Domain\Question;
use OAT\MultipleChoiceApi\Domain\QuestionCollection;

class QuestionMapper
{
    private ChoiceMapper $choiceMapper;

    public function __construct(ChoiceMapper $choiceMapper)
    {
        $this->choiceMapper = $choiceMapper;
    }

    public function mapArrayToDomain(array $data): Question
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return new Question(
            $data['text'],
            new DateTimeImmutable($data['createdAt']),
            $this->choiceMapper->mapCollection($data['choices'])
        );
    }

    public function mapArrayToCollection(array $data): QuestionCollection
    {
        return new QuestionCollection(...array_map([$this, 'mapArrayToDomain'], $data));
    }

    public function mapDomainToArray(Question $question): array
    {
        return [
            'text' => $question->getText(),
            'createdAt' => $question->getCreatedAt()->format(DATE_ATOM),
            'choices' => $this->choiceMapper->mapCollectionToArray($question->getChoices())
        ];
    }
}