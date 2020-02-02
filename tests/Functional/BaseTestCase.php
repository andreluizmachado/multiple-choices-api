<?php

namespace Tests\Functional;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class BaseTestCase extends TestCase
{
    protected bool $withMiddleware = true;

    protected ?App $app;

    protected ?ContainerInterface $container;

    public function runApp(string $requestMethod, string $requestUri, array $requestData = null): ResponseInterface
    {
        Dotenv::createImmutable(__DIR__ . '/../../')->load();

        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withHeader('Content-Type', 'application/json')
                ->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        return $this->app->process($request, $response);
    }

    public function bootstrap(): App
    {
        // Use the application settings
        $settings = require __DIR__ . '/../../app/settings.php';

        // Instantiate the application
        $this->app = new App($settings);

        // Set up dependencies
        $dependencies = require __DIR__ . '/../../app/dependencies.php';
        $dependencies($this->app);

        // Register middleware
        if ($this->withMiddleware) {
            $middleware = require __DIR__ . '/../../app/middleware.php';
            $middleware($this->app);
        }

        // Register routes
        $routes = require __DIR__ . '/../../app/routes.php';
        $routes($this->app);

        $this->container = $this->app->getContainer();

        return $this->app;
    }
}
