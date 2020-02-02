<?php declare(strict_types=1);


namespace OAT\MultipleChoiceApi\Infrastructure\Database\DataProvider;


interface ConnectionInterface
{
    public function connect(): void;
}