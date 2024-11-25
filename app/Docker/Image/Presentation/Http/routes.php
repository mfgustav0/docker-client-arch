<?php

declare(strict_types=1);

use App\Docker\Image\Presentation\Http\ImageController;
use Illuminate\Support\Facades\Route;

Route::prefix('images')->group(function (): void {
    Route::get('/', [ImageController::class, 'index']);
});
