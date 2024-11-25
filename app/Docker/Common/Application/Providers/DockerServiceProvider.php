<?php

declare(strict_types=1);

namespace App\Docker\Common\Application\Providers;

use App\Docker\Common\Domain\Interfaces\Http\DockerClientInterface;
use App\Docker\Common\Infrastructure\Exceptions\DockerClientException;
use App\Docker\Common\Infrastructure\Http\ApiDockerClient;
use App\Docker\Container\Application\Providers\ContainerServiceProvider;
use App\Docker\Image\Application\Providers\ImageServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

final class DockerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
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
        $this->app->bind(DockerClientInterface::class, function () {
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
