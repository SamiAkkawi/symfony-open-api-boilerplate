<?php declare(strict_types=1);

namespace App\OpenApiSpecification\ApiComponents\ComponentsParameter;

use App\OpenApiSpecification\ApiComponents\ComponentsExample;
use App\OpenApiSpecification\ApiComponents\ComponentsExamples;
use App\OpenApiSpecification\ApiComponents\ComponentsParameter\Parameter\ParameterDescription;
use App\OpenApiSpecification\ApiComponents\ComponentsParameter\Parameter\ParameterIsDeprecated;
use App\OpenApiSpecification\ApiComponents\ComponentsParameter\Parameter\ParameterIsRequired;
use App\OpenApiSpecification\ApiComponents\ComponentsParameter\Parameter\ParameterKey;
use App\OpenApiSpecification\ApiComponents\ComponentsParameter\Parameter\ParameterLocation;
use App\OpenApiSpecification\ApiComponents\ComponentsParameter\Parameter\ParameterName;
use App\OpenApiSpecification\ApiComponents\ComponentsParameter\Parameter\ParameterStyle;
use App\OpenApiSpecification\ApiComponents\ComponentsSchema\StringSchema;
use App\OpenApiSpecification\ApiException\SpecificationException;

final class StringParameter extends Parameter
{
    private static function generate(string $name, ParameterLocation $location): self
    {
        return new self(
            ParameterName::fromString($name),
            $location,
            StringSchema::generate(),
            $location->isInPath() ? ParameterIsRequired::generateTrue() : ParameterIsRequired::generateFalse(),
            ParameterIsDeprecated::generateFalse()
        );
    }

    public static function generateUuidInPath(string $name): self
    {
        return self::generateUuid($name, ParameterLocation::generatePath());
    }

    private static function generateUuid(string $name, ParameterLocation $location): self
    {
        return new self(
            ParameterName::fromString($name),
            $location,
            StringSchema::generateUuid(),
            $location->isInPath() ? ParameterIsRequired::generateTrue() : ParameterIsRequired::generateFalse(),
            ParameterIsDeprecated::generateFalse()
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
            $this->key,
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
            $this->key,
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
            $this->key,
            ParameterStyle::generateForm(),
            $this->example,
            $this->examples
        );
    }

    public function styleAsSimple(): self
    {
        throw SpecificationException::generateStyleNotSupportedForType(
            ParameterStyle::SIMPLE,
            $this->getParameterType()
        );
    }

    public function styleAsSpaceDelimited(): self
    {
        throw SpecificationException::generateStyleNotSupportedForType(
            ParameterStyle::SPACE_DELIMITED,
            $this->getParameterType()
        );
    }

    public function styleAsPipeDelimited(): self
    {
        throw SpecificationException::generateStyleNotSupportedForType(
            ParameterStyle::PIPE_DELIMITED,
            $this->getParameterType()
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
        return self::generate($name, ParameterLocation::generatePath());
    }

    public function setFormat(string $format): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema->setFormat($format),
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->key,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    /** @param string[] $options */
    public function setOptions(array $options): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema->setOptions($options),
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->key,
            $this->style,
            $this->example,
            $this->examples
        );
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
            $this->key,
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
            $this->key,
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
            $this->key,
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
            $this->key,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function setKey(string $key): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            ParameterKey::fromString($key),
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function setMinimumLength(int $minLength): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema->setMinimumLength($minLength),
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->key,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function setMaximumLength(int $maxLength): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema->setMaximumLength($maxLength),
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->key,
            $this->style,
            $this->example,
            $this->examples
        );
    }

    public function setExample(ComponentsExample $example): self
    {
        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->key,
            $this->style,
            $example,
            null
        );
    }

    public function addExample(ComponentsExample $example): self
    {
        if (!$example->hasName()) {
            throw SpecificationException::generateMustHaveKeyInComponents();
        }
        $examples = $this->examples;
        if (!$examples) {
            $examples = ComponentsExamples::generate();
        }

        if ($this->example) {
            $examples = $examples->addExample($this->example, $this->example->getName()->toString());
            $this->example = null;
        }

        return new self(
            $this->name,
            $this->location,
            $this->schema,
            $this->isRequired,
            $this->isDeprecated,
            $this->description,
            $this->key,
            $this->style,
            null,
            $examples
        );
    }

    public function getRouteRequirements(): ?string
    {
        $schemaType = $this->schema->getType();

        if ($schemaType->isStringUuid()) {
            return '[a-f\d]{8}(\-[a-f\d]{4}){3}\-[a-f\d]{12}';
        }

        if ($schemaType->isStringDate()) {
            return '[12]\d{3}\-(0[1-9]|1[0-2])\-(0[1-9]|[12]\d|3[01])';
        }

        return null;
    }
}