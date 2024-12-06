<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Presentation\Http;

use Illuminate\Http\JsonResponse;
use Modules\Docker\Image\Domain\Interfaces\Services\ImageServiceInterface;

final class ImageController
{
    public function index(ImageServiceInterface $imageService): JsonResponse
    {
        return response()->json(
            $imageService->listImages(),
        );
    }
}
