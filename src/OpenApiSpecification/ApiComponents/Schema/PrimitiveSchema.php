<?php declare(strict_types=1);

namespace App\OpenApiSpecification\ApiComponents\Schema;

use App\OpenApiSpecification\ApiComponents\Schema\Schema\SchemaType;

abstract class PrimitiveSchema extends DetailedSchema
{
    protected SchemaType $type;

    public function getType(): SchemaType
    {
        return $this->type;
    }

    public abstract static function generate();

    public abstract function setDescription(string $description);
}