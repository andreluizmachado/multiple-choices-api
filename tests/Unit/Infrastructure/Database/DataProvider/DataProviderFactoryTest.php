<?php declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Database\DataProvider;


use OAT\MultipleChoiceApi\Infrastructure\Database\DataProvider\DataProviderFactory;
use OAT\MultipleChoiceApi\Infrastructure\Database\DataProvider\FailToCreateDataProviderException;
use OAT\MultipleChoiceApi\Infrastructure\Database\DataProvider\QuestionJsonDataProvider;
use PHPUnit\Framework\TestCase;

class DataProviderFactoryTest extends TestCase
{
    private DataProviderFactory $sut;

    protected function setUp(): void
    {
        $this->sut = new DataProviderFactory();
    }

    public function testMakeInvalidDsn(): void
    {
        $this->expectException(FailToCreateDataProviderException::class);
        $this->expectExceptionMessage('There is no connector for the provided dsn');

        $this->sut->make('');
    }

    public function testMakeSuccess(): void
    {
        $this->assertEquals(
            new QuestionJsonDataProvider('/database/questions.json'),
            $this->sut->make('file:///database/questions.json')
        );
    }
}
