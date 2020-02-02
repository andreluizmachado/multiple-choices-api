<?php declare(strict_types=1);


namespace OAT\MultipleChoiceApi\Infrastructure\Database\Connection;


interface ConnectionInterface
{
    public function connect(): void;
}