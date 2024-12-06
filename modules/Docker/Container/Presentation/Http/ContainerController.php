<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Presentation\Http;

use Illuminate\Http\JsonResponse;
use Modules\Docker\Container\Domain\Interfaces\Services\ContainerServiceInterface;

final class ContainerController
{
    /**
     * Display a listing of containers.
     */
    public function index(ContainerServiceInterface $containerService): JsonResponse
    {
        return response()->json(
            $containerService->listContainers(),
        );
    }
}
