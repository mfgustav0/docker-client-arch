<?php

declare(strict_types=1);

namespace App\Docker\Image\Presentation\Http;

use App\Docker\Image\Domain\Interfaces\Services\ImageServiceInterface;
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
