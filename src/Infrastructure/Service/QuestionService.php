<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Service;

use OAT\MultipleChoiceApi\Domain\Choice;
use OAT\MultipleChoiceApi\Domain\Contracts\QuestionRepositoryInterface;
use OAT\MultipleChoiceApi\Domain\Contracts\QuestionServiceInterface;
use OAT\MultipleChoiceApi\Domain\Question;
use OAT\MultipleChoiceApi\Domain\QuestionCollection;
use OAT\MultipleChoiceApi\Domain\SearchRequest\QuestionSearchRequest;
use OAT\MultipleChoiceApi\Domain\SearchRequest\TranslationSearchRequest;
use OAT\MultipleChoiceApi\Infrastructure\Repository\TranslationRepository;

class QuestionService implements QuestionServiceInterface
{
    private QuestionRepositoryInterface $questionRepository;

    private TranslationRepository $translationRepository;

    public function __construct(
        QuestionRepositoryInterface $questionRepository,
        TranslationRepository $translationRepository
    ) {
        $this->questionRepository = $questionRepository;
        $this->translationRepository = $translationRepository;
    }

    public function find(QuestionSearchRequest $searchRequest): QuestionCollection
    {
        $questions = $this->questionRepository->fetchAll();

        if (TranslationRepository::DEFAULT_LANGUAGE === $searchRequest->getLanguage()) {
            return $questions;
        }

        /** @var Question $question */
        foreach ($questions as $question) {
            $question->setText(
                $this->translationRepository->first(
                    new TranslationSearchRequest(
                        TranslationRepository::DEFAULT_LANGUAGE,
                        $searchRequest->getLanguage(),
                        $question->getText()
                    )
                )
            );

            /** @var Choice $choice */
            foreach ($question->getChoiceCollection() as $choice) {
                $choice->setText(
                    $this->translationRepository->first(
                        new TranslationSearchRequest(
                            TranslationRepository::DEFAULT_LANGUAGE,
                            $searchRequest->getLanguage(),
                            $choice->getText()
                        )
                    )
                );
            }
        }

        return $questions;
    }
}