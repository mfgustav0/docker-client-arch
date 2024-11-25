<?php

declare(strict_types=1);

namespace App\Docker\Image\Domain\Interfaces\Repositories;

use App\Docker\Image\Domain\Entities\Image;

interface ImageRepositoryInterface
{
    /**
     * Retrieves a list of Docker images.
     *
     * @return array<Image>
     */
    public function listImages(bool $all = false): array;
}
