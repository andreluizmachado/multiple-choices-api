<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Database\Connection;

class StatementFactory
{
    public function make(string $dsnRaw): StatementInterface
    {
        $dsn = parse_url($dsnRaw);

        if(!isset($dsn['path'])) {
            throw new FailToCreateConnectionException('Please, specify the path');
        }

        $extension = pathinfo($dsn['path'], PATHINFO_EXTENSION);

        if ('json' === $extension)
        {
            return new JsonStatement($dsn['path']);
        }

        if ('csv' === $extension)
        {
            return new CsvStatement($dsn['path']);
        }

        throw new FailToCreateConnectionException('There is no connector for the provided dsn');
    }
}