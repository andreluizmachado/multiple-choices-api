<?php

namespace Tests\Functional;

use OAT\MultipleChoiceApi\Infrastructure\Database\DataProvider\DataProviderInterface;

class SaveQuestionActionTest extends BaseTestCase
{
    protected function setUp(): void
    {
        $this->bootstrap();
    }

    /**
     * @group caca
     */
    public function testSaveQuestionWithEmptyBody(): void
    {
        $databaseProvider = $this->createMock(DataProviderInterface::class);
        $this->container[DataProviderInterface::class] = $databaseProvider;

        $question = [
            'text' => 'What is your name',
            'createdAt' => '2019-06-01T00:00:00+00:00',
            'choices' =>
                [
                    [
                        'text' => 'Andre',
                    ],
                    [
                        'text' => 'John',
                    ],
                ],
        ];

        $databaseProvider->expects($this->never())->method('insert');

        $response = $this->runApp('POST', '/questions?lang=en', $question);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(
            ['error' => 'Error validating : NULL value found, but an object is required'],
            json_decode($response->getBody(), true)
        );
    }
}
