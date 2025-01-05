<?php

declare(strict_types=1);

namespace Modules\Docker\Common\Application\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Modules\Docker\Common\Domain\Interfaces\Http\DockerClientInterface;
use Modules\Docker\Common\Infrastructure\Exceptions\DockerClientException;
use Modules\Docker\Common\Infrastructure\Http\ApiDockerClient;
use Modules\Docker\Container\Application\Providers\ContainerServiceProvider;
use Modules\Docker\Image\Application\Providers\ImageServiceProvider;
use Override;

final class DockerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        $this->registerServiceProviders();

        $this->bindDockerClient();
    }

    /**
     * Register related service providers.
     */
    private function registerServiceProviders(): void
    {
        $this->app->register(ContainerServiceProvider::class);
        $this->app->register(ImageServiceProvider::class);
    }

    /**
     * Bind DockerClientInterface to its implementation.
     */
    private function bindDockerClient(): void
    {
        $this->app->bind(DockerClientInterface::class, function (): ApiDockerClient {
            $clientType = config('docker.default');

            if ('api' === $clientType) {
                return $this->createApiDockerClient();
            }

            throw DockerClientException::wrongClientProvider();
        });
    }

    /**
     * Create the ApiDockerClient instance.
     */
    private function createApiDockerClient(): ApiDockerClient
    {
        $httpClient = new Client([
            'base_uri' => config('docker.connections.api.url'),
            'curl' => [
                CURLOPT_UNIX_SOCKET_PATH => config('docker.connections.api.certificate_path'),
            ],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'verify' => false,
        ]);

        return new ApiDockerClient($httpClient);
    }
}
