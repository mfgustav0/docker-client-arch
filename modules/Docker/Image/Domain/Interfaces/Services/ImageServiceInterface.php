<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Domain\Interfaces\Services;

use Modules\Docker\Image\Domain\Entities\Image;

interface ImageServiceInterface
{
    /**
     * List Docker images.
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
