<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Presentation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Docker\Image\Domain\Interfaces\Services\ImageServiceInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

final readonly class ImageController
{
    /**
     * Create new instance
     */
    public function __construct(
        private ImageServiceInterface $imageService,
    ) {}

    /**
     * Display a listing of images.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $images = $this->imageService->listImages(
                all: $request->boolean('all'),
            );

            return response()->json(
                data: [
                    'data' => $images,
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
     * Display the images.
     */
    public function show(string $imageId): JsonResponse
    {
        try {
            $image = $this->imageService->inspectImage(
                imageId: $imageId,
            );

            return response()->json(
                data: $image->toArray(),
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
}
