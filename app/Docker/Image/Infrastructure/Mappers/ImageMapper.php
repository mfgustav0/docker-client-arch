<?php

declare(strict_types=1);

namespace App\Docker\Image\Infrastructure\Mappers;

use App\Docker\Image\Domain\Entities\Image;

final class ImageMapper
{
    /**
     * Map the input array to a Image object.
     */
    public static function createFromRequest(array $data): Image
    {
        return new Image(
            $data['Id'] ?? null,
            $data['ParentId'] ?? null,
            $data['RepoTags'] ?? [],
            $data['RepoDigests'] ?? [],
            $data['Created'] ?? null,
            $data['Size'] ?? null,
            $data['SharedSize'] ?? null,
            $data['VirtualSize'] ?? null,
            $data['Labels'] ?? [],
            $data['Containers'] ?? null,
            $data['Manifests'] ?? [],
        );
    }
}
