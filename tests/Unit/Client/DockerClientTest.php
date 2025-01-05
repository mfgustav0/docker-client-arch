<?php

declare(strict_types=1);

namespace Tests\Unit\Client;

use Modules\Docker\Common\Domain\Interfaces\Http\DockerClientInterface;
use Modules\Docker\Common\Infrastructure\Exceptions\DockerClientException;
use Tests\TestCase;

final class DockerClientTest extends TestCase
{
    public function test_app_should_return_instance_client_provider(): void
    {
        $dockerClient = $this->app->make(DockerClientInterface::class);

        $this->assertInstanceOf(DockerClientInterface::class, $dockerClient);
    }

    public function test_app_should_not_return_instance_client_provider_if_ha_invalid_configuration(): void
    {
        $this->expectExceptionObject(DockerClientException::wrongClientProvider());

        $this->app['config']->set('docker.default', 'invalid');

        $this->app->make(DockerClientInterface::class);
    }
}
