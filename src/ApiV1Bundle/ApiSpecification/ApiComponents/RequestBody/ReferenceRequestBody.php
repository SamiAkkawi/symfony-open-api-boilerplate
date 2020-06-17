<?php declare(strict=1);

namespace App\ApiV1Bundle\ApiSpecification\ApiComponents\RequestBody;

use App\ApiV1Bundle\ApiSpecification\ApiComponents\Reference;

final class ReferenceRequestBody
{
    private Reference $reference;
    private DetailedRequestBody $requestBody;

    private function __construct(
        Reference $reference,
        DetailedRequestBody $requestBody,
        ?RequestBodyName $name = null
    ) {
        $this->reference = $reference;
        $this->requestBody = $requestBody;
        $this->name = $name;
    }

    public static function generate(string $objectName, DetailedRequestBody $requestBody): self
    {
        return new self(Reference::generateRequestBodyReference($objectName), $requestBody);
    }

    public function setName(string $name): self
    {
        return new self($this->reference, $this->requestBody, RequestBodyName::fromString($name));
    }

    public function toDetailedRequestBody(): DetailedRequestBody
    {
        return $this->requestBody;
    }

    public function toOpenApi3Specification(): array
    {
        return $this->reference->toOpenApiSpecification();
    }
}