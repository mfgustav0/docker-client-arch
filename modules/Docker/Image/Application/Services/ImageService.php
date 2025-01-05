<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Application\Services;

use Modules\Docker\Image\Domain\Entities\Image;
use Modules\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use Modules\Docker\Image\Domain\Interfaces\Services\ImageServiceInterface;
use Override;

final readonly class ImageService implements ImageServiceInterface
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
    #[Override]
    public function listImages(bool $all = false): array
    {
        return $this->imageRepository->listImages($all);
    }

    /**
     * Return low-level information about an image.
     */
    #[Override]
    public function inspectImage(string $imageId): Image
    {
        return $this->imageRepository->inspectImage($imageId);
    }
}
