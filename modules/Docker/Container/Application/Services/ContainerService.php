<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Application\Services;

use Modules\Docker\Container\Domain\Entities\Container;
use Modules\Docker\Container\Domain\Interfaces\Repositories\ContainerRepositoryInterface;
use Modules\Docker\Container\Domain\Interfaces\Services\ContainerServiceInterface;

final class ContainerService implements ContainerServiceInterface
{
    /**
     * Create new instance
     */
    public function __construct(
        private ContainerRepositoryInterface $containerRepository,
    ) {}

    /**
     * Lists the available Docker containers.
     *
     * @return array<Container>
     */
    public function listContainers(bool $all = false): array
    {
        return $this->containerRepository->listContainers($all);
    }

    /**
     * Creates a new Docker container.
     */
    public function createContainer(string $image, string $name): Container
    {
        return $this->containerRepository->createContainer(
            $image,
            $name,
        );
    }

    /**
     * Starts a Docker container.
     */
    public function startContainer(string $containerId): bool
    {
        return $this->containerRepository->startContainer($containerId);
    }

    /**
     * Stops a running Docker container.
     */
    public function stopContainer(string $containerId): bool
    {
        return $this->containerRepository->stopContainer($containerId);
    }

    /**
     * Removes a Docker container.
     */
    public function removeContainer(string $containerId): bool
    {
        return $this->containerRepository->removeContainer($containerId);
    }
}
