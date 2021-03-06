<?php declare(strict_types=1);

namespace App\OpenApiSpecification\ApiComponents\ComponentsSchema\Schema;

final class SchemaMaximum
{
    private float $maximum;

    private function __construct(float $maximum)
    {
        $this->maximum = $maximum;
    }

    public static function fromInt(int $maximum): self
    {
        return new self((float)$maximum);
    }

    public static function fromFloat(float $maximum): self
    {
        return new self($maximum);
    }

    public function toInt(): int
    {
        return (int)$this->maximum;
    }

    public function toFloat(): float
    {
        return $this->maximum;
    }
}