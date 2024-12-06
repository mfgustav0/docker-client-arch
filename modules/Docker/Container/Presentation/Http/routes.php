<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Docker\Container\Presentation\Http\ContainerController;

Route::prefix('containers')->group(function (): void {
    Route::get('/', [ContainerController::class, 'index']);
});
