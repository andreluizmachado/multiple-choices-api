<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Database\Connection;

class QuestionJsonDataProvider implements DataProviderInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @inheritDoc
     */
    public function insert(array $question): void
    {
        $persistedData = $this->fetchAll();
        $persistedData[] = $question;

        file_put_contents($this->filePath, json_encode($persistedData));
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(): array
    {
        return json_decode(file_get_contents($this->filePath), true);
    }
}