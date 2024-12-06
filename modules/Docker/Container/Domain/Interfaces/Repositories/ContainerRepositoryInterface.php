<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Domain\Interfaces\Repositories;

use Modules\Docker\Container\Domain\Entities\Container;

interface ContainerRepositoryInterface
{
    /**
     * Retrieves a list of Docker containers.
     *
     * @return array<Container>
     */
    public function listContainers(bool $all = false): array;

    /**
     * Creates a new Docker container in the repository.
     */
    public function createContainer(string $image, string $name): Container;

    /**
     * Starts a Docker container from the repository.
     */
    public function startContainer(string $containerId): bool;

    /**
     * Stops a running Docker container in the repository.
     */
    public function stopContainer(string $containerId): bool;

    /**
     * Removes a Docker container from the repository.
     */
    public function removeContainer(string $containerId): bool;
}
