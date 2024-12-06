<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Presentation\Http;

use Modules\Docker\Image\Domain\Interfaces\Services\ImageServiceInterface;
use Illuminate\Http\JsonResponse;

final class ImageController
{
    public function index(ImageServiceInterface $imageService): JsonResponse
    {
        return response()->json(
            $imageService->listImages(),
        );
    }
}
