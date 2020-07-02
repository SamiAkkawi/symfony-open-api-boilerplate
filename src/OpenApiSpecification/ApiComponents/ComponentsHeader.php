<?php declare(strict_types=1);

namespace App\OpenApiSpecification\ApiComponents;

use App\OpenApiSpecification\ApiComponents\ComponentsHeader\DetailedHeader;
use App\OpenApiSpecification\ApiComponents\ComponentsHeader\Header\HeaderKey;

abstract class ComponentsHeader
{
    protected ?HeaderKey $key;

    public abstract function setKey(string $key);

    public abstract function toDetailedHeader(): DetailedHeader;

    public function hasKey(): bool
    {
        return (bool)$this->key;
    }

    public function getKey(): ?HeaderKey
    {
        return $this->key;
    }

    public abstract function toOpenApiSpecification(): array;
}