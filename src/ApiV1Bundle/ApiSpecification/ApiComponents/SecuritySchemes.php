<?php declare(strict=1);
// Created by sami-akkawi on 10.05.20

namespace App\ApiV1Bundle\ApiSpecification\ApiComponents;

use App\ApiV1Bundle\ApiSpecification\ApiComponents\ComponentsSecurityScheme\SecurityScheme\SchemeName;
use App\ApiV1Bundle\ApiSpecification\ApiException\SpecificationException;

final class SecuritySchemes
{
    /** @var SecurityScheme[] */
    private array $schemes;

    private function __construct(array $schemes)
    {
        $this->schemes = $schemes;
    }

    public static function generate(): self
    {
        return new self([]);
    }

    private function hasScheme(SchemeName $name): bool
    {
        foreach ($this->schemes as $scheme) {
            if ($scheme->getSchemeName()->isIdenticalTo($name)) {
                return true;
            }
        }
        return false;
    }

    public function addScheme(SecurityScheme $scheme): self
    {
        if ($this->hasScheme($scheme->getSchemeName())) {
            throw SpecificationException::generateDuplicateDefinitionException($scheme->getSchemeName()->toString());
        }
        return new self(array_merge($this->schemes, [$scheme]));
    }

    public function toOpenApiSpecification(): array
    {
        $specifications = [];

        foreach ($this->schemes as $scheme) {
            $specifications[$scheme->getSchemeName()->toString()] = $scheme->toOpenApiSpecification();
        }

        return $specifications;
    }

    public function isDefined(): bool
    {
        return (bool)count($this->schemes);
    }
}