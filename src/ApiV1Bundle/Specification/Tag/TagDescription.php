<?php declare(strict=1);

namespace App\ApiV1Bundle\Specification\Tag;

/**
 * A short description for the tag.
 * https://swagger.io/specification/#tag-object
 */

final class TagDescription
{
    private string $description;

    private function __construct(string $description)
    {
        $this->description = $description;
    }

    public static function fromString(string $description): self
    {
        return new self($description);
    }

    public function toString(): string
    {
        return $this->description;
    }
}