<?php declare(strict_types=1);

use Monolog\Logger;

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => Logger::DEBUG,
        ],
        'schemas' => [
            'question' => __DIR__ . '/../public/schema/Question.json',
            'questionSearchRequest' => __DIR__ . '/../public/schema/QuestionSearchRequest.json',
        ],
    ],
];
