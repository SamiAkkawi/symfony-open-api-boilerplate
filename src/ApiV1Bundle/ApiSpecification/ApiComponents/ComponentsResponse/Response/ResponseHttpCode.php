<?php declare(strict=1);
// Created by sami-akkawi on 19.05.20

namespace App\ApiV1Bundle\ApiSpecification\ApiComponents\ComponentsResponse\Response;

use App\ApiV1Bundle\ApiSpecification\ApiException\SpecificationException;

/**
 * Any HTTP status code can be used as the property name, but only one property per code, to describe the expected
 * response for that HTTP status code. A Reference Object can link to a response that is defined in the OpenAPI Object's
 * components/responses section. This field MUST be enclosed in quotation marks (for example, "200") for compatibility
 * between JSON and YAML. To define a range of response codes, this field MAY contain the uppercase wildcard character X.
 * For example, 2XX represents all response codes between [200-299]. Only the following range definitions are allowed:
 * 1XX, 2XX, 3XX, 4XX, and 5XX. If a response is defined using an explicit code, the explicit code definition takes
 * precedence over the range definition for that code.
 * https://swagger.io/specification/#responses-object
 */

final class ResponseHttpCode
{
    private const OK = '200';
    private const CREATED = '201';

    private string $statusCode;

    private function __construct(string $statusCode)
    {
        if (empty($statusCode)) {
            throw SpecificationException::generateEmptyStringException(self::class);
        }
        $this->statusCode = $statusCode;
    }

    public static function fromInt(int $statusCode): self
    {
        return new self((string)$statusCode);
    }

    public function toString(): string
    {
        return $this->statusCode;
    }

    public function isIdenticalTo(self $statusCode): bool
    {
        return $this->toString() === $statusCode->toString();
    }
}