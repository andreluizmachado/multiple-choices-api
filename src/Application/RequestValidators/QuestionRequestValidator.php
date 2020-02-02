<?php declare(strict_types=1);

namespace OAT\MultipleChoiceApi\Application\RequestValidators;

use JsonSchema\Constraints\Constraint;
use JsonSchema\Exception\ValidationException;
use JsonSchema\Validator;
use Slim\Http\Request;

class QuestionRequestValidator
{
    private Validator $validator;

    private string $schema;

    public function __construct(Validator $validator, string $schema)
    {
        $this->validator = $validator;
        $this->schema = $schema;
    }

    public function validate(Request $request): void
    {
        $data = null !== $request->getParsedBody()
            ? json_decode((string)$request->getBody())
            : (object)$request->getQueryParams();

        try {
            $this->validator->validate(
                $data,
                (object)['$ref' => 'file://' . realpath($this->schema)],
                Constraint::CHECK_MODE_EXCEPTIONS
            );
        } catch (ValidationException $e) {
            throw new BadRequestException($e->getMessage());
        }
    }
}