<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Database\DataProvider;

class DataProviderFactory
{
    public function make(string $dsnRaw): DataProviderInterface
    {
        $dsn = parse_url($dsnRaw);

        $extension = pathinfo($dsn['path'], PATHINFO_EXTENSION);

        if ('json' === $extension)
        {
            return new QuestionJsonDataProvider($dsn['path']);
        }

        if ('csv' === $extension)
        {
            return new QuestionCsvDataProvider($dsn['path']);
        }

        throw new FailToCreateDataProviderException('There is no connector for the provided dsn');
    }
}