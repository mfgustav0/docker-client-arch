<?php

declare(strict_types=1);

namespace Tests\Fixtures\Images;

use Modules\Docker\Common\Infrastructure\Exceptions\DockerClientException;
use Modules\Docker\Image\Domain\Entities\Image;
use Modules\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use Modules\Docker\Image\Infrastructure\Mappers\ImageMapper;

final class ImageFakeRepository implements ImageRepositoryInterface
{
    /**
     * Indicates if the repository should simulate errors.
     */
    private bool $simulateError;

    /**
     * Mocked list of images for testing purposes.
     */
    private array $mockedImages;

    /**
     * Create new instance.
     */
    public function __construct(bool $simulateError = false)
    {
        $this->simulateError = $simulateError;
        $this->mockedImages = $this->generateMockedImages();
    }

    /**
     * Retrieves a list of Docker images.
     *
     * @return array<Image>
     */
    public function listImages(bool $all = false): array
    {
        $this->throwErrorIfSimulated();

        $filtered = $all
            ? $this->mockedImages
            : array_filter($this->mockedImages, fn(array $image): bool => 'running' === $image['State']);

        return array_map(
            fn(array $data): Image => ImageMapper::createFromRequest($data),
            $filtered,
        );
    }

    /**
     * Return low-level information about an image.
     *
     * @return Image
     */
    public function inspectImage(string $imageId): Image
    {
        $this->throwErrorIfSimulated();

        $imageData = array_filter(
            $this->mockedImages,
            fn(array $image): bool => $image['Id'] === $imageId,
        );

        if (empty($imageData)) {
            throw new DockerClientException("No such image: {$imageId}");
        }

        return ImageMapper::createFromRequest(array_values($imageData)[0]);
    }

    /**
     * Generates an initial list of mocked containers.
     */
    private function generateMockedImages(): array
    {
        return [
            [
                'Id' => 'mocked-image-1',
                'ParentId' => null,
                'RepoTags' => ['8.3-mock'],
                'RepoDigests' => [],
                'Created' => 1733798478,
                'Size' => 143519206,
                'SharedSize' => -1,
                'VirtualSize' => null,
                'Labels' => [
                    'app.name' => 'mock',
                ],
                'Containers' => -1,
                'Manifests' => [],
                'State' => 'running',
            ],
            [
                'Id' => 'mocked-image-2',
                'ParentId' => null,
                'RepoTags' => ['3-mock'],
                'RepoDigests' => [],
                'Created' => 1733798478,
                'Size' => 143519206,
                'SharedSize' => -1,
                'VirtualSize' => null,
                'Labels' => [
                    'app.name' => 'mock-2',
                ],
                'Containers' => -1,
                'Manifests' => [],
                'State' => 'exited',
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
