<?php declare(strict=1);

namespace App\ApiV1Bundle\ApiSpecification\ApiComponents\Header;

use App\ApiV1Bundle\ApiSpecification\ApiComponents\Example;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Examples;
use App\ApiV1Bundle\ApiSpecification\ApiComponents\Schema;

abstract class SchemaHeader extends DetailedHeader
{
    protected Schema $schema;

    protected function __construct(
        HeaderIsRequired $isRequired,
        HeaderIsDeprecated $isDeprecated,
        Schema $schema,
        ?HeaderDescription $description = null,
        ?HeaderDocName $docName = null,
        ?Example $example = null,
        ?Examples $examples = null
    ) {
        parent::__construct($isRequired, $isDeprecated, $description, $docName, $example, $examples);
        $this->schema = $schema;
    }

    public abstract function makeNullable();

    public function toOpenApiSpecification(): array
    {
        $specification = [
            'schema' => $this->schema->toOpenApiSpecification()
        ];

        if ($this->isRequired->toBool()) {
            $specification['required'] = true;
        }

        if ($this->isDeprecated->toBool()) {
            $specification['deprecated'] = true;
        }

        if ($this->description) {
            $specification['description'] = $this->description->toString();
        }

        if ($this->example) {
            $specification['example'] = $this->example->toOpenApiSpecification();
        }

        if ($this->examples) {
            $specification['examples'] = $this->examples->toOpenApiSpecification();
        }

        return $specification;
    }
}