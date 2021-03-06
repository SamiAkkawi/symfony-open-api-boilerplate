<?php declare(strict_types=1);

namespace App\OpenApiSpecification;

/**
 * REQUIRED. This string MUST be the semantic version number of the OpenAPI Specification version that
 * the OpenAPI document uses. The openapi field SHOULD be used by tooling specifications and clients to
 * interpret the OpenAPI document. This is not related to the API info.version string.
 * http://spec.openapis.org/oas/v3.0.3#fixed-fields
 */

final class OpenApiVersion
{
    private const VERSION = '3.0.3';
    private string $version;

    private function __construct(string $version)
    {
        $this->version = $version;
    }

    public static function generate(): self
    {
        return new self(self::VERSION);
    }

    public function toString(): string
    {
        return $this->version;
    }
}