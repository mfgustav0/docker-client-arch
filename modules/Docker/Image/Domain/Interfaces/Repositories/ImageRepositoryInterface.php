<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Domain\Interfaces\Repositories;

use Modules\Docker\Image\Domain\Entities\Image;

interface ImageRepositoryInterface
{
    /**
     * Retrieves a list of Docker images.
     *
     * @return array<Image>
     */
    public function listImages(bool $all = false): array;

    /**
     * Return low-level information about an image.
     *
     * @return Image
     */
    public function inspectImage(string $imageId): Image;
}
