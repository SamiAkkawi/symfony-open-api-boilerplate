<?php declare(strict_types=1);

namespace App\OpenApiSpecification\ApiInfo;

use App\OpenApiSpecification\ApiInfo\InfoLicense\LicenseName;
use App\OpenApiSpecification\ApiInfo\InfoLicense\LicenseUrl;

/**
 * The license information for the exposed API.
 * http://spec.openapis.org/oas/v3.0.3#info-object
 */

final class InfoLicense
{
    private LicenseName $name;
    private ?LicenseUrl $url;

    private function __construct(LicenseName $name, ?LicenseUrl $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    public static function generate(string $name): self
    {
        return new self(LicenseName::fromString($name), null);
    }

    public function setUrl(string $url): self
    {
        return new self(
            $this->name,
            LicenseUrl::fromString($url)
        );
    }

    public function toOpenApiSpecification(): array
    {
        $specification = [
            'name' => $this->name->toString()
        ];
        if ($this->url) {
            $specification['url'] = $this->url->toString();
        }
        return $specification;
    }
}