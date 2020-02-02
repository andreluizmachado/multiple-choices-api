<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Database\Connection;

class JsonStatement implements StatementInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @inheritDoc
     */
    public function insert(array $data): void
    {
        $persistedData = $this->fetchAll();
        $persistedData[] = $data;

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