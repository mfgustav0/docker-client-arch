<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Infrastructure\Repository;

use Modules\Docker\Common\Domain\Interfaces\Http\DockerClientInterface;
use Modules\Docker\Image\Domain\Entities\Image;
use Modules\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use Modules\Docker\Image\Infrastructure\Mappers\ImageMapper;
use Override;

final class ImageApiRepository implements ImageRepositoryInterface
{
    /**
     * Create new instance
     */
    public function __construct(
        private DockerClientInterface $dockerClient,
    ) {}

    /**
     * Retrieves a list of Docker images.
     *
     * @return array<Image>
     */
    #[Override]
    public function listImages(bool $all = false): array
    {
        $result = $this->dockerClient->get('/images/json', [
            'query' => ['all' => $all],
        ]);

        return array_map(
            fn(array $data): Image => ImageMapper::createFromRequest($data),
            $result->response,
        );
    }

    /**
     * Return low-level information about an image.
     *
     * @return Image
     */
    #[Override]
    public function inspectImage(string $imageId): Image
    {
        $result = $this->dockerClient->get("/images/{$imageId}/json");

        return ImageMapper::createFromRequest($result->response);
    }
}
