<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Infrastructure\Database\Connection;

use Throwable;

interface DataProviderInterface
{
    /**
     * @param array $question
     *@throws Throwable
 */
    public function insert(array $question): void;

    /**
     * @throws Throwable
     */
    public function fetchAll(): array;
}