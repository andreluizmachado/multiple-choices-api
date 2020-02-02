<?php declare(strict_types=1);


namespace OAT\MultipleChoiceApi\Infrastructure\Database\Connection;


use Throwable;

class QuestionCsvDataProvider implements DataProviderInterface, ConnectionInterface
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
    public function insert(array $question): void
    {
        $data = [
            $question['text'],
            $question['createdAt']
        ];

        $data = array_merge(
            $data,
            array_map(
                fn( array $choice) => $choice['text'],
                $question['choices']
            )
        );

        $this->connect();

        fputcsv($this->connection, $data);
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(): array
    {
        $this->connect();

        $data = [];

        while ($line = fgetcsv($this->connection)) {
            $question = [
                'text' => $line[0],
                'createdAt' => $line[1],
            ];
            unset($line[0], $line[1]);

            $question['choices'] = array_map(fn(string $choice) => ['text' => $choice], $line);

            $data[] = $question;
        }

        unset($data[0]);

        return $data;
    }
}