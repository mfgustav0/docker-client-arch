<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Presentation\Http;

use Modules\Docker\Container\Domain\Interfaces\Services\ContainerServiceInterface;
use Illuminate\Http\JsonResponse;

final class ContainerController
{
    public function index(ContainerServiceInterface $containerService): JsonResponse
    {
        return response()->json(
            $containerService->listContainers(),
        );
    }
}
