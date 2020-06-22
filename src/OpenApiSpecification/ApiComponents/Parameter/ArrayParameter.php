<?php declare(strict_types=1);

namespace App\OpenApiSpecification\ApiComponents\Parameter;

use App\OpenApiSpecification\ApiComponents\Example;
use App\OpenApiSpecification\ApiComponents\Examples;
use App\OpenApiSpecification\ApiComponents\Schema;
use App\OpenApiSpecification\ApiComponents\Schema\ArraySchema;
use App\OpenApiSpecification\ApiComponents\Schema\StringSchema;
use App\OpenApiSpecification\ApiException\SpecificationException;

final class ArrayParameter extends DetailedParameter
{
    private static function generate(string $name, ParameterLocation $location): self
    {
        if ($location->isInPath()) {
            throw SpecificationException::generateCannotBeInPath('ArrayParameter');
        }

        return new self(
            ParameterName::fromString($name),
            $location,
            ArraySchema::generate(StringSchema::generate()),
            $location->isInPath() ? ParameterIsRequired::generateTrue() : ParameterIsRequired::generateFalse(),
            ParameterIsDeprecated::generateFalse(),
        );
    }

    public function setItemSchema(Schema $itemSchema): self
    {
        return new self(
            $this->name,
            $this->location,
            ArraySchema::generate($itemSchema),
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function styleAsMatrix(): self
    {
        if (!$this->location->isInPath()) {
            throw SpecificationException::generateStyleNotSupportedForLocation(
                ParameterStyle::MATRIX,
                $this->location->toString()
            );
        }

        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            ParameterStyle::generateMatrix(),
            $this->example,
            $this->examples
        );
    }

    public function styleAsLabel(): self
    {
        if (!$this->location->isInPath()) {
            throw SpecificationException::generateStyleNotSupportedForLocation(
                ParameterStyle::LABEL,
                $this->location->toString()
            );
        }

        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            ParameterStyle::generateLabel(),
            $this->example,
            $this->examples
        );
    }

    public function styleAsForm(): self
    {
        if (!$this->location->isInQuery() && !$this->location->isInCookie()) {
            throw SpecificationException::generateStyleNotSupportedForLocation(
                ParameterStyle::FORM,
                $this->location->toString()
            );
        }

        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            ParameterStyle::generateForm(),
            $this->example,
            $this->examples
        );
    }

    public function styleAsSimple(): self
    {
        if (!$this->location->isInPath() && !$this->location->isInHeader()) {
            throw SpecificationException::generateStyleNotSupportedForLocation(
                ParameterStyle::FORM,
                $this->location->toString()
            );
        }

        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            ParameterStyle::generateSimple(),
            $this->example,
            $this->examples
        );
    }

    public function styleAsSpaceDelimited(): self
    {
        if (!$this->location->isInQuery()) {
            throw SpecificationException::generateStyleNotSupportedForLocation(
                ParameterStyle::SPACE_DELIMITED,
                $this->location->toString()
            );
        }

        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            ParameterStyle::generateSpaceDelimited(),
            $this->example,
            $this->examples
        );
    }

    public function styleAsPipeDelimited(): self
    {
        if (!$this->location->isInQuery()) {
            throw SpecificationException::generateStyleNotSupportedForLocation(
                ParameterStyle::PIPE_DELIMITED,
                $this->location->toString()
            );
        }

        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            ParameterStyle::generatePipeDelimited(),
            $this->example,
            $this->examples
        );
    }

    public function styleAsDeepObject(): self
    {
        throw SpecificationException::generateStyleNotSupportedForType(
            ParameterStyle::DEEP_OBJECT,
            $this->getParameterType()
        );
    }

    public static function generateInCookie(string $name): self
    {
        return self::generate($name, ParameterLocation::generateCookie());
    }

    public static function generateInQuery(string $name): self
    {
        return self::generate($name, ParameterLocation::generateQuery());
    }

    public static function generateInHeader(string $name): self
    {
        return self::generate($name, ParameterLocation::generateHeader());
    }

    public static function generateInPath(string $name): self
    {
        throw SpecificationException::generateCannotBeInPath('ArrayParameter');
    }

    public function makeNullable(): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema->makeNullable(),
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function setMinimumItems(int $minItems): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema->setMinimumItems($minItems),
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function setMaximumItems(int $maxItems): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema->setMaximumItems($maxItems),
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function require(): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema,
            ParameterIsRequired::generateTrue(),
            $this->isDeprecated,
            $this->description,
            $this->docName,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function deprecate(): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            ParameterIsDeprecated::generateTrue(),
            $this->description,
            $this->docName,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function setDescription(string $description): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            ParameterDescription::fromString($description),
            $this->docName,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function setDocName(string $name): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            ParameterDocName::fromString($name),
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function setExample(Example $example): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            $this->style,
            $example,
            null
        );
    }

    public function addExample(Example $example): self
    {
        if (!$example->hasName()) {
            throw SpecificationException::generateMustHaveKeyInComponents();
        }

        $examples = $this->examples;
        if (!$examples) {
            $examples = Examples::generate();
        }

        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->docName,
            $this->style,
            null,
            $examples->addExample($example, $example->getName()->toString())
        );
    }
}