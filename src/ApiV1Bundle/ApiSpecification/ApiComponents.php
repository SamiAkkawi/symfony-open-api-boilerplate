<?php declare(strict=1);

namespace App\ApiV1Bundle\ApiSpecification;

use App\ApiV1Bundle\ApiSpecification\ApiComponents\Example;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Examples;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Parameter;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Parameters;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Response;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Responses;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Schema;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Schemas;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\SecurityScheme;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\SecuritySchemes;
use App\ApiV1Bundle\ApiSpecification\ApiException\SpecificationException;

final class ApiComponents
{
    private Schemas $schemas;
    private Responses $responses;
    private Parameters $parameters;
    private Examples $examples;
    // todo: private RequestBodies $requestBodies
    // todo: private Headers $headers
    private SecuritySchemes $securitySchemes;
    // todo: private Links $links

    private function __construct(
        Schemas $schemas,
        Responses $responses,
        Parameters $parameters,
        Examples $examples,
        SecuritySchemes $securitySchemes
    ) {
        $this->schemas = $schemas;
        $this->responses = $responses;
        $this->parameters = $parameters;
        $this->examples = $examples;
        $this->securitySchemes = $securitySchemes;
    }

    public static function generate(): self
    {
        return new self(
            Schemas::generate(),
            Responses::generate(),
            Parameters::generate(),
            Examples::generate(),
            SecuritySchemes::generate()
        );
    }

    public function addSecurityScheme(SecurityScheme $scheme): self
    {
        return new self(
            $this->schemas,
            $this->responses,
            $this->parameters,
            $this->examples,
            $this->securitySchemes->addScheme($scheme),
        );
    }

    public function addSchema(Schema $schema): self
    {
        if (!$schema->hasName()) {
            throw SpecificationException::generateMustHaveKeyInComponents();
        }

        return new self(
            $this->schemas->addSchema($schema),
            $this->responses,
            $this->parameters,
            $this->examples,
            $this->securitySchemes
        );
    }

    public function addResponse(Response $response): self
    {
        if (!$response->hasName()) {
            throw SpecificationException::generateMustHaveKeyInComponents();
        }

        return new self(
            $this->schemas,
            $this->responses->addResponse($response),
            $this->parameters,
            $this->examples,
            $this->securitySchemes
        );
    }

    public function addParameter(Parameter $parameter): self
    {
        if (!$parameter->hasDocName()) {
            throw SpecificationException::generateMustHaveKeyInComponents();
        }

        return new self(
            $this->schemas,
            $this->responses,
            $this->parameters->addParameter($parameter),
            $this->examples,
            $this->securitySchemes
        );
    }

    public function addExample(Example $example): self
    {
        if (!$example->hasName()) {
            throw SpecificationException::generateMustHaveKeyInComponents();
        }

        return new self(
            $this->schemas,
            $this->responses,
            $this->parameters,
            $this->examples->addExample($example, $example->getName()->toString()),
            $this->securitySchemes
        );
    }

    public function toOpenApiSpecification(): array
    {
        $specifications = [];
        if ($this->responses->isDefined()) {
            $specifications['responses'] =  $this->responses->toOpenApiSpecificationForComponents();
        }
        if ($this->schemas->isDefined()) {
            $specifications['schemas'] =  $this->schemas->toOpenApiSpecificationForComponents();
        }
        if ($this->parameters->isDefined()) {
            $specifications['parameters'] =  $this->parameters->toOpenApiSpecificationForComponents();
        }
        if ($this->examples->isDefined()) {
            $specifications['examples'] =  $this->examples->toOpenApiSpecification();
        }
        if ($this->securitySchemes->isDefined()) {
            $specifications['securitySchemes'] =  $this->securitySchemes->toOpenApiSpecification();
        }
        return $specifications;
    }

    public function isDefined(): bool
    {
        return (
            $this->schemas->isDefined()
            || $this->securitySchemes->isDefined()
            || $this->responses->isDefined()
            || $this->examples->isDefined()
            || $this->parameters->isDefined()
        );
    }
}