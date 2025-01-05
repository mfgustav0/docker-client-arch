<?php

declare(strict_types=1);

namespace Tests\Unit\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Docker\Common\Domain\Interfaces\Http\DockerClientInterface;
use Modules\Docker\Common\Infrastructure\Exceptions\DockerClientException;
use Override;
use Tests\TestCase;

final class ApiDockerClientTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('docker.default', 'api');
    }

    public function test_get_method_should_return_valid_response(): void
    {
        $this->mockHttpClient(
            method: 'GET',
            url: '/test-endpoint',
            statusCode: 200,
            body: '{"message": "success"}',
        );

        /** @var DockerClientInterface $dockerClient */
        $dockerClient = $this->app->make(DockerClientInterface::class);

        $response = $dockerClient->get('/test-endpoint');

        $this->assertTrue($response->isStatus(200));
        $this->assertEquals(['message' => 'success'], $response->response);
    }

    public function test_post_method_should_return_valid_response(): void
    {
        $this->mockHttpClient(
            method: 'POST',
            url: '/test-endpoint',
            statusCode: 201,
            body: '{"message": "success"}',
        );

        /** @var DockerClientInterface $dockerClient */
        $dockerClient = $this->app->make(DockerClientInterface::class);

        $response = $dockerClient->post('/test-endpoint');

        $this->assertTrue($response->isStatus(201));
        $this->assertEquals(['message' => 'success'], $response->response);
    }

    public function test_put_method_should_return_valid_response(): void
    {
        $this->mockHttpClient(
            method: 'PUT',
            url: '/test-endpoint',
            statusCode: 204,
        );

        /** @var DockerClientInterface $dockerClient */
        $dockerClient = $this->app->make(DockerClientInterface::class);

        $response = $dockerClient->put('/test-endpoint');

        $this->assertTrue($response->isStatus(204));
        $this->assertEquals(null, $response->response);
    }

    public function test_delete_method_should_return_valid_response(): void
    {
        $this->mockHttpClient(
            method: 'DELETE',
            url: '/test-endpoint',
            statusCode: 204,
        );

        /** @var DockerClientInterface $dockerClient */
        $dockerClient = $this->app->make(DockerClientInterface::class);

        $response = $dockerClient->delete('/test-endpoint');

        $this->assertTrue($response->isStatus(204));
        $this->assertEquals(null, $response->response);
    }

    public function test_send_request_should_throw_docker_client_exception_on_client_exception(): void
    {
        $exceptionMessage = 'An error occurred';
        $mockResponseBody = json_encode(['message' => $exceptionMessage]);

        $responseMock = new Response(400, [], $mockResponseBody);

        $clientExceptionMock = $this->createMock(ClientException::class);
        $clientExceptionMock->method('getResponse')
            ->willReturn($responseMock);

        $httpClientMock = $this->createMock(ClientInterface::class);
        $httpClientMock->method('request')
            ->willThrowException($clientExceptionMock);

        $this->app->singleton('docker.http-client', fn(): ClientInterface => $httpClientMock);

        /** @var DockerClientInterface $dockerClient */
        $dockerClient = $this->app->make(DockerClientInterface::class);

        $this->expectException(DockerClientException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $dockerClient->get('/test-endpoint');
    }

    public function test_send_request_should_throw_docker_client_exception_on_connect_exception(): void
    {
        $httpClientMock = $this->createMock(ClientInterface::class);

        $httpClientMock->method('request')
            ->willThrowException(new ConnectException('Connection failed', new Request('GET', '/test-endpoint')));

        $this->app->singleton('docker.http-client', fn(): ClientInterface => $httpClientMock);

        /** @var DockerClientInterface $dockerClient */
        $dockerClient = $this->app->make(DockerClientInterface::class);

        $this->expectExceptionObject(DockerClientException::failedToConnect());

        $dockerClient->get('/test-endpoint');
    }

    private function mockHttpClient(string $method, string $url, int $statusCode, string|null $body = null): void
    {
        $responseMock = new Response($statusCode, [], $body);
        $httpClientMock = $this->createMock(ClientInterface::class);
        $httpClientMock->method('request')
            ->with($method, $url, [])
            ->willReturn($responseMock);

        $this->app->singleton('docker.http-client', fn(): ClientInterface => $httpClientMock);
    }
}
