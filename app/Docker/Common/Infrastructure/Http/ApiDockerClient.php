<?php

declare(strict_types=1);

namespace App\Docker\Common\Infrastructure\Http;

use App\Docker\Common\Domain\Entities\Response;
use App\Docker\Common\Domain\Interfaces\Http\DockerClientInterface;
use GuzzleHttp\ClientInterface;

final class ApiDockerClient implements DockerClientInterface
{
    /**
     * Create new instance
     */
    public function __construct(
        private ClientInterface $httpClient,
    ) {}

    /**
     * Perform a GET request to the Docker API.
     */
    public function get(string $uri, array $options = []): Response
    {
        return $this->sendRequest('GET', $uri, $options);
    }

    /**
     * Perform a POST request to the Docker API.
     */
    public function post(string $uri, array $options = []): Response
    {
        return $this->sendRequest('POST', $uri, $options);
    }

    /**
     * Perform a PUT request to the Docker API.
     */
    public function put(string $uri, array $options = []): Response
    {
        return $this->sendRequest('PUT', $uri, $options);
    }

    /**
     * Perform a Delete request to the Docker API.
     */
    public function delete(string $uri, array $options = []): Response
    {
        return $this->sendRequest('DELETE', $uri, $options);
    }

    /**
     * Sends a HTTP request and returns the response.
     */
    private function sendRequest(string $method, string $uri, array $options = []): Response
    {
        $response = $this->httpClient->request($method, $uri, $options);

        $json = json_decode($response->getBody()->getContents(), true);

        return new Response(
            response: $json,
            status: $response->getStatusCode(),
        );
    }
}
