<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Domain\Entities;

final readonly class Image
{
    /**
     * Image entity representing a Docker image.
     */
    public function __construct(
        public ?string $id,
        public ?string $parentId = null,
        public array $repositoryTags = [],
        public array $repositoryDigests = [],
        public ?string $created = null,
        public ?int $size = null,
        public ?int $virtualSize = null,
        public array $labels = [],
        public ?string $dockerVersion = null,
        public ?string $architecture = null,
        public ?string $os = null,
        public ?string $osVersion = null,
        public array $config = [],
        public array $rootFs = [],
        public array $graphDriver = [],
        public ?string $author = null,
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
