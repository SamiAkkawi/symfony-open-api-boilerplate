<?php declare(strict=1);

namespace App\ApiV1Bundle\ApiSpecification\ApiComponents;

use App\ApiV1Bundle\ApiSpecification\ApiComponents\Example\DetailedExample;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Example\ExampleName;

abstract class Example
{
    protected ?ExampleName $name;

    public abstract function toDetailedExample(): DetailedExample;

    public abstract function setName(string $name);

    public function isValidForSchema(Schema $schema): array
    {
        return $schema->isValueValid($this->toDetailedExample()->getLiteralValue());
    }

    public function getName(): ?ExampleName
    {
        return $this->name;
    }

    public function hasName(): bool
    {
        return (bool)$this->name;
    }

    public abstract function getLiteralValue();

    public abstract function toOpenApiSpecification(): array;
}