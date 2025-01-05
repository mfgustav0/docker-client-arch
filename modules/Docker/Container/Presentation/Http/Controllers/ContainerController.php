<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Presentation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Docker\Container\Domain\Interfaces\Services\ContainerServiceInterface;
use Modules\Docker\Container\Presentation\Http\Requests\StoreContainerRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

final readonly class ContainerController
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
            $containers = $this->containerService->listContainers(
                all: $request->boolean('all'),
            );

            return response()->json(
                data: [
                    'data' => $containers,
                ],
                status: HttpResponse::HTTP_OK,
            );
        } catch (Throwable $throwable) {
            return response()->json(
                data: [
                    'error' => $throwable->getMessage(),
                ],
                status: HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

    /**
     * Store container.
     */
    public function store(StoreContainerRequest $request): JsonResponse
    {
        try {
            $container = $this->containerService->createContainer(
                image: $request->validated('image'),
                name: $request->validated('name'),
            );

            return response()->json(
                data: $container->toArray(),
                status: HttpResponse::HTTP_CREATED,
            );
        } catch (Throwable $throwable) {
            return response()->json(
                data: [
                    'error' => $throwable->getMessage(),
                ],
                status: HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

    /**
     * Start container.
     */
    public function start(string $containerId): JsonResponse
    {
        try {
            $this->containerService->startContainer(
                containerId: $containerId,
            );

            return response()->json(
                status: HttpResponse::HTTP_NO_CONTENT,
            );
        } catch (Throwable $throwable) {
            return response()->json(
                data: [
                    'error' => $throwable->getMessage(),
                ],
                status: HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

    /**
     * Stop container.
     */
    public function stop(string $containerId): JsonResponse
    {
        try {
            $this->containerService->stopContainer(
                containerId: $containerId,
            );

            return response()->json(
                status: HttpResponse::HTTP_NO_CONTENT,
            );
        } catch (Throwable $throwable) {
            return response()->json(
                data: [
                    'error' => $throwable->getMessage(),
                ],
                status: HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

    /**
     * Destroy container.
     */
    public function destroy(string $containerId): JsonResponse
    {
        try {
            $this->containerService->removeContainer(
                containerId: $containerId,
            );

            return response()->json(
                status: HttpResponse::HTTP_NO_CONTENT,
            );
        } catch (Throwable $throwable) {
            return response()->json(
                data: [
                    'error' => $throwable->getMessage(),
                ],
                status: HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
