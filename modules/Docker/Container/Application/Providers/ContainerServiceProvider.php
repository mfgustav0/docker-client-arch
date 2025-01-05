<?php

declare(strict_types=1);

namespace Modules\Docker\Container\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Docker\Container\Application\Services\ContainerService;
use Modules\Docker\Container\Domain\Interfaces\Repositories\ContainerRepositoryInterface;
use Modules\Docker\Container\Domain\Interfaces\Services\ContainerServiceInterface;
use Modules\Docker\Container\Infrastructure\Repository\ContainerApiRepository;
use Override;

final class ContainerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
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

        $this->app->register(RouteServiceProvider::class);
    }
}
