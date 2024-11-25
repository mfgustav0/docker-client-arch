<?php

declare(strict_types=1);

namespace App\Docker\Container\Domain\Interfaces\Services;

use App\Docker\Container\Domain\Entities\Container;

interface ContainerServiceInterface
{
    /**
     * Lists the available Docker containers.
     *
     * @return array<Container>
     */
    public function listContainers(bool $all = false): array;

    /**
     * Creates a new Docker container.
     */
    public function createContainer(string $image, string $name): Container;

    /**
     * Starts a Docker container.
     */
    public function startContainer(string $containerId): bool;

    /**
     * Stops a running Docker container.
     */
    public function stopContainer(string $containerId): bool;

    /**
     * Removes a Docker container.
     */
    public function removeContainer(string $containerId): bool;
}
