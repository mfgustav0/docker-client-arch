<?php

declare(strict_types=1);

namespace App\Docker\Image\Domain\Interfaces\Services;

use App\Docker\Image\Domain\Entities\Image;

interface ImageServiceInterface
{
    /**
     * List Docker images.
     *
     * @return array<Image>
     */
    public function listImages(bool $all = false): array;
}
