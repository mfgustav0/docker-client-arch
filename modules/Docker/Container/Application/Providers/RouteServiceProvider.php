<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Application\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ProvidersRouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Docker\Container\Presentation\Http\Controllers\ContainerController;
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
            Route::prefix('containers')->group(function (): void {
                Route::get('/', [ContainerController::class, 'index']);
                Route::post('/', [ContainerController::class, 'store']);
                Route::post('/{containerId}/start', [ContainerController::class, 'start']);
                Route::put('/{containerId}/stop', [ContainerController::class, 'stop']);
                Route::delete('/{containerId}', [ContainerController::class, 'destroy']);
            });
        });
    }
}
