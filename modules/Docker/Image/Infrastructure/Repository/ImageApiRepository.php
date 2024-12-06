<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Infrastructure\Repository;

use Modules\Docker\Common\Domain\Interfaces\Http\DockerClientInterface;
use Modules\Docker\Image\Domain\Entities\Image;
use Modules\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use Modules\Docker\Image\Infrastructure\Mappers\ImageMapper;

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
