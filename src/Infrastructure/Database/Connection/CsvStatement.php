<?php declare(strict_types=1);


namespace OAT\MultipleChoiceApi\Infrastructure\Database\Connection;


use Throwable;

class CsvStatement implements StatementInterface, ConnectionInterface
{
    private const MODE = 'a+';

    private string $filePath;

    private $connection = null;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function connect(): void
    {
        if (null === $this->connection)
        {
            $this->connection = fopen($this->filePath, self::MODE);
        }
    }

    /**
     * @inheritDoc
     */
    public function insert(array $data): void
    {
        fputcsv($this->connection, $data);
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(): array
    {
        return fgetcsv($this->connection);
    }
}