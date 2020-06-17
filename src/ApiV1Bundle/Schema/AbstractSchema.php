<?php declare(strict=1);

namespace App\ApiV1Bundle\Schema;

use App\ApiV1Bundle\ApiSpecification\ApiComponents\Schema\DetailedSchema;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Schema\ReferenceSchema;

abstract class AbstractSchema
{
    public abstract function toDetailedSchema(): DetailedSchema;

    public static function getOpenApiSchema(): DetailedSchema
    {
        return static::getOpenApiSchemaWithoutName()->setName(static::getClassName());
    }

    protected abstract static function getOpenApiSchemaWithoutName(): DetailedSchema;

    public static function getReferenceSchema(): ReferenceSchema
    {
        return ReferenceSchema::generate(static::getClassName(), static::getOpenApiSchemaWithoutName());
    }

    public abstract static function getAlwaysRequiredFields(): array;

    public abstract function requireOnly(array $fieldNames);

    private static function getClassName(): string
    {
        $path = explode('\\', static::class);
        return array_pop($path);
    }
}