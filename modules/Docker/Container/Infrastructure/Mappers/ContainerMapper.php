<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Infrastructure\Mappers;

use Modules\Docker\Container\Domain\Entities\Container;

final class ContainerMapper
{
    /**
     * Map the input array to a Container object.
     */
    public static function createFromRequest(array $data): Container
    {
        return new Container(
            $data['Id'] ?? null,
            $data['Names'] ?? [],
            $data['Image'] ?? null,
            $data['ImageID'] ?? null,
            $data['Command'] ?? null,
            $data['Created'] ?? null,
            $data['State'] ?? null,
            $data['Status'] ?? null,
            $data['Ports'] ?? [],
            $data['Labels'] ?? [],
            $data['SizeRw'] ?? null,
            $data['SizeRootFs'] ?? null,
            $data['HostConfig'] ?? [],
            $data['NetworkSettings'] ?? [],
            $data['Mounts'] ?? [],
        );
    }
}
