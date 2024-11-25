<?php

declare(strict_types=1);

use App\Docker\Container\Presentation\Http\ContainerController;
use Illuminate\Support\Facades\Route;

Route::prefix('containers')->group(function (): void {
    Route::get('/', [ContainerController::class, 'index']);
});
