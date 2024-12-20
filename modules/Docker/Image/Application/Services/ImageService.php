<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Application\Services;

use Modules\Docker\Image\Domain\Entities\Image;
use Modules\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use Modules\Docker\Image\Domain\Interfaces\Services\ImageServiceInterface;

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

    /**
     * Return low-level information about an image.
     *
     * @return Image
     */
    public function inspectImage(string $name): Image
    {
        return $this->imageRepository->inspectImage($name);
    }
}
