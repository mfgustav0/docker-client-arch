<?php

declare(strict_types=1);

namespace App\Docker\Container\Domain\Entities;

final class Container
{
    /**
     * Container entity representing a Docker Container.
     */
    public function __construct(
        public readonly ?string $id,
        public readonly array $names = [],
        public readonly ?string $image = null,
        public readonly ?string $imageId = null,
        public readonly ?string $command = null,
        public readonly ?int $created = null,
        public readonly ?string $state = null,
        public readonly ?string $status = null,
        public readonly array $ports = [],
        public readonly array $labels = [],
        public readonly ?int $sizeRw = null,
        public readonly ?int $sizeRootFs = null,
        public readonly array $hostConfig = [],
        public readonly array $networkSettings = [],
        public readonly array $mounts = [],
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
