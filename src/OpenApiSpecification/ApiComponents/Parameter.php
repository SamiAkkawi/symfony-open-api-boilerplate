<?php declare(strict_types=1);

namespace App\OpenApiSpecification\ApiComponents;

use App\OpenApiSpecification\ApiComponents\Parameter\DetailedParameter;
use App\OpenApiSpecification\ApiComponents\Parameter\ParameterDocName;
use App\OpenApiSpecification\ApiComponents\Parameter\ParameterName;

/**
 * Describes a single operation parameter.
 * A unique parameter is defined by a combination of a name and location.
 * http://spec.openapis.org/oas/v3.0.3#parameter-object
 */

abstract class Parameter
{
    protected ?ParameterDocName $docName;

    public abstract function setDocName(string $name);

    public abstract function getName(): ParameterName;

    public abstract function isRequired(): bool;

    public abstract function toDetailedParameter(): DetailedParameter;

    public function hasDocName(): bool
    {
        return (bool)$this->docName;
    }

    public function getDocName(): ?ParameterDocName
    {
        return $this->docName;
    }

    public abstract function toOpenApiSpecification(): array;

    public function isQueryParameter(): bool
    {
        return $this->toDetailedParameter()->getLocation()->isInQuery();
    }

    public function isHeaderParameter(): bool
    {
        return $this->toDetailedParameter()->getLocation()->isInHeader();
    }

    public function isCookieParameter(): bool
    {
        return $this->toDetailedParameter()->getLocation()->isInCookie();
    }

    public abstract function isValueValid($value): array;

    public abstract function getSchema(): Schema;
}