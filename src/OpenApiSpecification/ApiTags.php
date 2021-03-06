<?php declare(strict_types=1);

namespace App\OpenApiSpecification;

use App\OpenApiSpecification\ApiTag\TagName;

/**
 * A list of tags used by the specification with additional metadata. The order of the tags can be used to reflect on
 * their order by the parsing tools. Not all tags that are used by the Operation Object must be declared.
 * The tags that are not declared MAY be organized randomly or based on the tools' logic.
 * Each tag name in the list MUST be unique.
 * http://spec.openapis.org/oas/v3.0.3#fixed-fields
 */

final class ApiTags
{
    /** @var ApiTag[] */
    private array $tags;

    private function __construct(array $tags)
    {
        $this->tags = $tags;
    }

    public static function generate(): self
    {
        return new self([]);
    }

    private function hasTag(TagName $name): bool
    {
        foreach ($this->tags as $tag) {
            if ($tag->getName()->isIdenticalTo($name)) {
                return true;
            }
        }
        return false;
    }

    public function addTags(ApiTag $tag): self
    {
        return new self(array_merge($this->tags, [$tag]));
    }

    public function toTags(): array
    {
        return $this->tags;
    }

    public function mergeTags(self $tags): self
    {
        $newTags = $this;
        foreach ($tags->toTags() as $tag) {
            if (!$newTags->hasTag($tag->getName())) {
                $newTags = $newTags->addTag($tag);
            }
        }
        return $newTags;
    }

    public function addTag(ApiTag $tag): self
    {
        return new self(array_merge($this->tags, [$tag]));
    }

    public function toOpenApiSpecification(): array
    {
        $specifications = [];
        foreach ($this->tags as $tag) {
            $specifications[$tag->getName()->toString()] = $tag->toOpenApiSpecification();
        }

        ksort($specifications);

        return array_values($specifications);
    }

    public function hasTags(): bool
    {
        return (bool)count($this->tags);
    }
}