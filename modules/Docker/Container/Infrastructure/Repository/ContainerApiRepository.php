<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Infrastructure\Repository;

use Modules\Docker\Common\Domain\Interfaces\Http\DockerClientInterface;
use Modules\Docker\Container\Domain\Entities\Container;
use Modules\Docker\Container\Domain\Interfaces\Repositories\ContainerRepositoryInterface;
use Modules\Docker\Container\Infrastructure\Mappers\ContainerMapper;

final class ContainerApiRepository implements ContainerRepositoryInterface
{
    /**
     * Create new instance
     */
    public function __construct(
        private DockerClientInterface $dockerClient,
    ) {}

    /**
     * Retrieves a list of Docker containers.
     *
     * @return array<Container>
     */
    public function listContainers(bool $all = false): array
    {
        $result = $this->dockerClient->get('/containers/json', [
            'query' => ['all' => $all],
        ]);

        return array_map(
            fn(array $data): Container => ContainerMapper::createFromRequest($data),
            $result->response,
        );
    }

    /**
     * Creates a new Docker container in the repository.
     */
    public function createContainer(string $image, string $name): Container
    {
        $result = $this->dockerClient->post('/containers/create', [
            'json' => [
                'Image' => $image,
                'Name' => $name,
            ],
        ]);

        return ContainerMapper::createFromRequest($result->response);
    }

    /**
     * Starts a Docker container from the repository.
     */
    public function startContainer(string $containerId): bool
    {
        $result = $this->dockerClient->post("/containers/{$containerId}/start");

        return $result->isStatus(204);
    }

    /**
     * Stops a running Docker container in the repository.
     */
    public function stopContainer(string $containerId): bool
    {
        $result = $this->dockerClient->post("/containers/{$containerId}/stop");

        return $result->isStatus(204);
    }

    /**
     * Removes a Docker container from the repository.
     */
    public function removeContainer(string $containerId): bool
    {
        $result = $this->dockerClient->delete("/containers/{$containerId}");

        return $result->isStatus(204);
    }
}
