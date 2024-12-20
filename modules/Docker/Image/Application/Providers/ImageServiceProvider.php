<?php

declare(strict_types=1);

namespace Modules\Docker\Image\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Docker\Image\Application\Services\ImageService;
use Modules\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use Modules\Docker\Image\Domain\Interfaces\Services\ImageServiceInterface;
use Modules\Docker\Image\Infrastructure\Repository\ImageApiRepository;

final class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ImageRepositoryInterface::class,
            ImageApiRepository::class,
        );

        $this->app->bind(
            ImageServiceInterface::class,
            ImageService::class,
        );

        $this->app->register(RouteServiceProvider::class);
    }
}
