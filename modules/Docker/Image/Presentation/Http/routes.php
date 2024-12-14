<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Docker\Image\Presentation\Http\ImageController;

Route::prefix('images')->group(function (): void {
    Route::get('/', [ImageController::class, 'index']);
});
