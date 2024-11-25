<?php

declare(strict_types=1);

namespace App\Docker\Image\Application\Services;

use App\Docker\Image\Domain\Entities\Image;
use App\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use App\Docker\Image\Domain\Interfaces\Services\ImageServiceInterface;

final class ImageService implements ImageServiceInterface
{
    /**
     * Create new instance
     */
    public function __construct(
        private ImageRepositoryInterface $imageRepository,
    ) {}

    /**
     * List Docker images.
     *
     * @return array<Image>
     */
    public function listImages(bool $all = false): array
    {
        return $this->imageRepository->listImages($all);
    }
}
