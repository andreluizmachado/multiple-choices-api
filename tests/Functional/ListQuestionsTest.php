<?php

namespace Tests\Functional;

use OAT\MultipleChoiceApi\Infrastructure\Database\DataProvider\DataProviderInterface;

class ListQuestionsTest extends BaseTestCase
{
    protected function setUp(): void
    {
        $this->bootstrap();
    }

    public function testGetQuestions(): void
    {
        $databaseProvider = $this->createMock(DataProviderInterface::class);
        $this->container[DataProviderInterface::class] = $databaseProvider;

        $questionList = [
            [
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
            ],
            [
                'text' => 'Another Question',
                'createdAt' => '2019-06-01T00:00:00+00:00',
                'choices' =>
                    [
                        [
                            'text' => 'test1',
                        ],
                        [
                            'text' => 'test2',
                        ],
                    ],
            ]
        ];
        $databaseProvider->expects($this->once())->method('fetchAll')->willReturn(
            $questionList
        );

        $response = $this->runApp('GET', '/questions?lang=en');


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
            ['data' => $questionList],
            json_decode($response->getBody(), true)
        );
    }

    public function testGetQuestionsTranslated(): void
    {
        $databaseProvider = $this->createMock(DataProviderInterface::class);
        $this->container[DataProviderInterface::class] = $databaseProvider;

        $questionList = [
            [
                'text' => 'What is your name',
                'createdAt' => '2019-06-01T00:00:00+00:00',
                'choices' =>
                    [
                        [
                            'text' => 'My name is Andre',
                        ],
                        [
                            'text' => 'My Name is John',
                        ],
                    ],
            ],
            [
                'text' => 'Another Question',
                'createdAt' => '2019-06-01T00:00:00+00:00',
                'choices' =>
                    [
                        [
                            'text' => 'Another test1',
                        ],
                        [
                            'text' => 'test2',
                        ],
                    ],
            ]
        ];

        $databaseProvider->expects($this->once())->method('fetchAll')->willReturn(
            $questionList
        );

        $response = $this->runApp('GET', '/questions?lang=pt');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
            [
                'data' =>
                    [
                        [
                            'text' => 'Qual é o seu nome',
                            'createdAt' => '2019-06-01T00:00:00+00:00',
                            'choices' =>
                                [
                                    [
                                        'text' => 'Meu nome é andre',
                                    ],
                                    [
                                        'text' => 'Meu nome é John',
                                    ],
                                ],
                        ],
                        [
                            'text' => 'Outra pergunta',
                            'createdAt' => '2019-06-01T00:00:00+00:00',
                            'choices' =>
                                [
                                    [
                                        'text' => 'Outro teste1',
                                    ],
                                    [
                                        'text' => 'test2',
                                    ],
                                ],
                        ],
                    ],
            ],
            json_decode($response->getBody(), true)
        );
    }
}
