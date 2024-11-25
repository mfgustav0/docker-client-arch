<?php

declare(strict_types=1);

namespace App\Docker\Image\Infrastructure\Repository;

use App\Docker\Common\Domain\Interfaces\Http\DockerClientInterface;
use App\Docker\Image\Domain\Entities\Image;
use App\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use App\Docker\Image\Infrastructure\Mappers\ImageMapper;

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
}
