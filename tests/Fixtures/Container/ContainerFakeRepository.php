<?php

declare(strict_types=1);

namespace Tests\Fixtures\Container;

use Modules\Docker\Common\Infrastructure\Exceptions\DockerClientException;
use Modules\Docker\Container\Domain\Entities\Container;
use Modules\Docker\Container\Domain\Interfaces\Repositories\ContainerRepositoryInterface;
use Modules\Docker\Container\Infrastructure\Mappers\ContainerMapper;

final class ContainerFakeRepository implements ContainerRepositoryInterface
{
    /**
     * Indicates if the repository should simulate errors.
     */
    private bool $simulateError;

    /**
     * Mocked list of containers for testing purposes.
     */
    private array $mockedContainers;

    /**
     * Create new instance.
     */
    public function __construct(bool $simulateError = false)
    {
        $this->simulateError = $simulateError;
        $this->mockedContainers = $this->generateMockedContainers();
    }

    /**
     * Retrieves a list of Docker containers.
     *
     * @return array<Container>
     */
    public function listContainers(bool $all = false): array
    {
        $this->throwErrorIfSimulated();

        $filtered = $all
            ? $this->mockedContainers
            : array_filter($this->mockedContainers, fn($container) => 'running' === $container['State']);

        return array_map(
            fn(array $data): Container => ContainerMapper::createFromRequest($data),
            $filtered,
        );
    }

    /**
     * Creates a new Docker container in the repository.
     */
    public function createContainer(string $image, string $name): Container
    {
        $this->throwErrorIfSimulated();

        $newContainer = [
            'Id' => 'mocked-id-' . uniqid(),
            'Names' => ["/{$name}"],
            'Image' => $image,
            'State' => 'created',
            'Status' => 'Created',
        ];

        $this->mockedContainers[] = $newContainer;

        return ContainerMapper::createFromRequest($newContainer);
    }

    /**
     * Starts a Docker container from the repository.
     */
    public function startContainer(string $containerId): bool
    {
        $this->throwErrorIfSimulated();

        foreach ($this->mockedContainers as &$container) {
            if ($container['Id'] === $containerId) {
                $container['State'] = 'running';
                $container['Status'] = 'Up 1 second';
                return true;
            }
        }

        return false; // Container not found
    }

    /**
     * Stops a running Docker container in the repository.
     */
    public function stopContainer(string $containerId): bool
    {
        $this->throwErrorIfSimulated();

        foreach ($this->mockedContainers as &$container) {
            if ($container['Id'] === $containerId && 'running' === $container['State']) {
                $container['State'] = 'exited';
                $container['Status'] = 'Exited (0) just now';
                return true;
            }
        }

        return false; // Container not running or not found
    }

    /**
     * Removes a Docker container from the repository.
     */
    public function removeContainer(string $containerId): bool
    {
        $this->throwErrorIfSimulated();

        foreach ($this->mockedContainers as $key => $container) {
            if ($container['Id'] === $containerId) {
                unset($this->mockedContainers[$key]);
                return true;
            }
        }

        return false; // Container not found
    }

    /**
     * Generates an initial list of mocked containers.
     */
    private function generateMockedContainers(): array
    {
        return [
            [
                'Id' => 'mocked-id-123',
                'Names' => ['/mocked-container-1'],
                'Image' => 'mocked-image-1',
                'State' => 'running',
                'Status' => 'Up 5 minutes',
            ],
            [
                'Id' => 'mocked-id-456',
                'Names' => ['/mocked-container-2'],
                'Image' => 'mocked-image-2',
                'State' => 'exited',
                'Status' => 'Exited (0) 10 minutes ago',
            ],
        ];
    }

    /**
     * Simulates an error if $simulateError is true.
     *
     * @throws DockerClientException
     */
    private function throwErrorIfSimulated(): void
    {
        if ($this->simulateError) {
            throw DockerClientException::failedToConnect();
        }
    }
}
