<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Domain\Entities;

final readonly class Container
{
    /**
     * Container entity representing a Docker Container.
     */
    public function __construct(
        public ?string $id,
        public array $names = [],
        public ?string $image = null,
        public ?string $imageId = null,
        public ?string $command = null,
        public ?int $created = null,
        public ?string $state = null,
        public ?string $status = null,
        public array $ports = [],
        public array $labels = [],
        public ?int $sizeRw = null,
        public ?int $sizeRootFs = null,
        public array $hostConfig = [],
        public array $networkSettings = [],
        public array $mounts = [],
    ) {}

    /**
     * Convert the Container entity to an associative array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'names' => $this->names,
            'image' => $this->image,
            'imageId' => $this->imageId,
            'command' => $this->command,
            'created' => $this->created,
            'state' => $this->state,
            'status' => $this->status,
            'ports' => $this->ports,
            'labels' => $this->labels,
            'sizeRw' => $this->sizeRw,
            'sizeRootFs' => $this->sizeRootFs,
            'hostConfig' => $this->hostConfig,
            'networkSettings' => $this->networkSettings,
            'mounts' => $this->mounts,
        ];
    }
}
