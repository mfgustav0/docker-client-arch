<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Application\Services;

use Modules\Docker\Container\Domain\Entities\Container;
use Modules\Docker\Container\Domain\Interfaces\Repositories\ContainerRepositoryInterface;
use Modules\Docker\Container\Domain\Interfaces\Services\ContainerServiceInterface;
use Override;

final readonly class ContainerService implements ContainerServiceInterface
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
    #[Override]
    public function listContainers(bool $all = false): array
    {
        return $this->containerRepository->listContainers($all);
    }

    /**
     * Creates a new Docker container.
     */
    #[Override]
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
    #[Override]
    public function startContainer(string $containerId): bool
    {
        return $this->containerRepository->startContainer($containerId);
    }

    /**
     * Stops a running Docker container.
     */
    #[Override]
    public function stopContainer(string $containerId): bool
    {
        return $this->containerRepository->stopContainer($containerId);
    }

    /**
     * Removes a Docker container.
     */
    #[Override]
    public function removeContainer(string $containerId): bool
    {
        return $this->containerRepository->removeContainer($containerId);
    }
}
