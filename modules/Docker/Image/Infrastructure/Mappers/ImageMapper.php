<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Infrastructure\Mappers;

use Modules\Docker\Image\Domain\Entities\Image;

final class ImageMapper
{
    /**
     * Map the input array to a Image object.
     */
    public static function createFromRequest(array $data): Image
    {
        return new Image(
            $data['Id'] ?? null,
            $data['Parent'] ?? null,
            $data['RepoTags'] ?? [],
            $data['RepoDigests'] ?? [],
            $data['Created'] ?? null,
            $data['Size'] ?? null,
            $data['VirtualSize'] ?? null,
            $data['Labels'] ?? [],
            $data['DockerVersion'] ?? null,
            $data['Architecture'] ?? null,
            $data['Os'] ?? null,
            $data['OsVersion'] ?? null,
            $data['Config'] ?? [],
            $data['RootFS'] ?? [],
            $data['GraphDriver'] ?? [],
            $data['Author'] ?? null,
        );
    }
}
