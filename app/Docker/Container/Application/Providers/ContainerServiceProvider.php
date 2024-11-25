<?php

declare(strict_types=1);

namespace App\Docker\Container\Application\Providers;

use App\Docker\Container\Application\Services\ContainerService;
use App\Docker\Container\Domain\Interfaces\Repositories\ContainerRepositoryInterface;
use App\Docker\Container\Domain\Interfaces\Services\ContainerServiceInterface;
use App\Docker\Container\Infrastructure\Repository\ContainerApiRepository;
use Illuminate\Support\ServiceProvider;

final class ContainerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ContainerRepositoryInterface::class,
            ContainerApiRepository::class,
        );

        $this->app->bind(
            ContainerServiceInterface::class,
            ContainerService::class,
        );

        $this->loadRoutesFrom(__DIR__ . '/../../Presentation/Http/routes.php');
    }
}
