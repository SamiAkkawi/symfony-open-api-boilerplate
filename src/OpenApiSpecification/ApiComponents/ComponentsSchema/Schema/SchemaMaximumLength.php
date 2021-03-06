<?php declare(strict_types=1);

namespace App\OpenApiSpecification\ApiComponents\ComponentsSchema\Schema;

final class SchemaMaximumLength
{
    private int $maximumLength;

    private function __construct(int $maximumLength)
    {
        $this->maximumLength = $maximumLength;
    }

    public static function fromInt(int $maximumLength): self
    {
        return new self($maximumLength);
    }

    public function toInt(): int
    {
        return $this->maximumLength;
    }
}