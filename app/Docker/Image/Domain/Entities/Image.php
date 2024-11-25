<?php

declare(strict_types=1);

namespace App\Docker\Image\Domain\Entities;

final class Image
{
    /**
     * Image entity representing a Docker image.
     */
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $parentId = null,
        public readonly array $repositoryTags = [],
        public readonly array $repositoryDigests = [],
        public readonly ?int $created = null,
        public readonly ?int $size = null,
        public readonly ?int $sharedSize = null,
        public readonly ?int $virtualSize = null,
        public readonly array $labels = [],
        public readonly ?int $containers = null,
        public readonly array $manifests = [],
    ) {}

    /**
     * Convert the Image entity to an associative array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'parentId' => $this->parentId,
            'repositoryTags' => $this->repositoryTags,
            'repositoryDigests' => $this->repositoryDigests,
            'created' => $this->created,
            'size' => $this->size,
            'sharedSize' => $this->sharedSize,
            'virtualSize' => $this->virtualSize,
            'labels' => $this->labels,
            'containers' => $this->containers,
            'manifests' => $this->manifests,
        ];
    }
}
