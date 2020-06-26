<?php declare(strict_types=1);

namespace App\OpenApiSpecification\ApiComponents;

use App\OpenApiSpecification\ApiComponents\ComponentsParameter\Parameter;
use App\OpenApiSpecification\ApiComponents\ComponentsParameter\Parameter\ParameterKey;
use App\OpenApiSpecification\ApiComponents\ComponentsParameter\Parameter\ParameterName;

/**
 * Describes a single operation parameter.
 * A unique parameter is defined by a combination of a name and location.
 * http://spec.openapis.org/oas/v3.0.3#parameter-object
 */

abstract class ComponentsParameter
{
    protected ?ParameterKey $key;

    public abstract function setKey(string $key);

    public abstract function getName(): ParameterName;

    public abstract function isRequired(): bool;

    public abstract function toParameter(): Parameter;

    public function hasKey(): bool
    {
        return (bool)$this->key;
    }

    public function getKey(): ?ParameterKey
    {
        return $this->key;
    }

    public abstract function toOpenApiSpecification(): array;

    public function isQueryParameter(): bool
    {
        return $this->toParameter()->getLocation()->isInQuery();
    }

    public function isHeaderParameter(): bool
    {
        return $this->toParameter()->getLocation()->isInHeader();
    }

    public function isCookieParameter(): bool
    {
        return $this->toParameter()->getLocation()->isInCookie();
    }

    public function isPathParameter(): bool
    {
        return $this->toParameter()->getLocation()->isInPath();
    }

    public abstract function isValueValid($value): array;

    public abstract function getSchema(): ComponentsSchema;
}