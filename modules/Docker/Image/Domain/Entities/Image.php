<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Domain\Entities;

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
        public readonly ?string $created = null,
        public readonly ?int $size = null,
        public readonly ?int $virtualSize = null,
        public readonly array $labels = [],
        public readonly ?string $dockerVersion = null,
        public readonly ?string $architecture = null,
        public readonly ?string $os = null,
        public readonly ?string $osVersion = null,
        public readonly array $config = [],
        public readonly array $rootFs = [],
        public readonly array $graphDriver = [],
        public readonly ?string $author = null,
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
            'virtualSize' => $this->virtualSize,
            'labels' => $this->labels,
            'dockerVersion' => $this->dockerVersion,
            'architecture' => $this->architecture,
            'os' => $this->os,
            'osVersion' => $this->osVersion,
            'config' => $this->config,
            'rootFs' => $this->rootFs,
            'graphDriver' => $this->graphDriver,
            'author' => $this->author,
        ];
    }
}
