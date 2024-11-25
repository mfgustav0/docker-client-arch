<?php

declare(strict_types=1);

namespace App\Docker\Container\Presentation\Http;

use App\Docker\Container\Domain\Interfaces\Services\ContainerServiceInterface;
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
