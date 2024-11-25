<?php

declare(strict_types=1);

namespace App\Docker\Image\Application\Providers;

use App\Docker\Image\Application\Services\ImageService;
use App\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use App\Docker\Image\Domain\Interfaces\Services\ImageServiceInterface;
use App\Docker\Image\Infrastructure\Repository\ImageApiRepository;
use Illuminate\Support\ServiceProvider;

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

        $this->loadRoutesFrom(__DIR__ . '/../../Presentation/Http/routes.php');
    }
}
