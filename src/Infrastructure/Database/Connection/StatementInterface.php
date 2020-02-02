<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Database\Connection;

use Throwable;

interface StatementInterface
{
    /**
     * @throws Throwable

     * @param array $data
     */
    public function insert(array $data): void;

    /**
     * @throws Throwable
     */
    public function fetchAll(): array;
}