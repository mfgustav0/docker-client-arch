<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Presentation\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Docker\Container\Domain\Interfaces\Services\ContainerServiceInterface;
use Throwable;

final class ContainerController
{
    /**
     * Create new instance
     */
    public function __construct(
        private ContainerServiceInterface $containerService,
    ) {}

    /**
     * Display a listing of containers.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $containers = $this->containerService->listContainers($request->boolean('all'));

            return response()->json(
                data: [
                    'data' => $containers,
                ],
            );
        } catch (Throwable $throwable) {
            return response()->json([
                'error' => $throwable->getMessage(),
            ], 500);
        }
    }
}
