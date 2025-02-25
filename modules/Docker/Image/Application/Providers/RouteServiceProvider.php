<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Application\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ProvidersRouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Docker\Image\Presentation\Http\Controllers\ImageController;
use Override;

final class RouteServiceProvider extends ProvidersRouteServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    #[Override]
    public function boot(): void
    {
        $this->routes(function (): void {
            Route::prefix('images')->group(function (): void {
                Route::get('/', [ImageController::class, 'index']);
                Route::get('/{imageId}', [ImageController::class, 'show']);
            });
        });
    }
}
