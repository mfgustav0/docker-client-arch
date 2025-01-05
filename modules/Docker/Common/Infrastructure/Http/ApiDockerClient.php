<?php

declare(strict_types=1);

namespace Modules\Docker\Common\Infrastructure\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Modules\Docker\Common\Domain\Entities\Response;
use Modules\Docker\Common\Domain\Interfaces\Http\DockerClientInterface;
use Modules\Docker\Common\Infrastructure\Exceptions\DockerClientException;
use Override;

final readonly class ApiDockerClient implements DockerClientInterface
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
    #[Override]
    public function get(string $uri, array $options = []): Response
    {
        return $this->sendRequest('GET', $uri, $options);
    }

    /**
     * Perform a POST request to the Docker API.
     */
    #[Override]
    public function post(string $uri, array $options = []): Response
    {
        return $this->sendRequest('POST', $uri, $options);
    }

    /**
     * Perform a PUT request to the Docker API.
     */
    #[Override]
    public function put(string $uri, array $options = []): Response
    {
        return $this->sendRequest('PUT', $uri, $options);
    }

    /**
     * Perform a Delete request to the Docker API.
     */
    #[Override]
    public function delete(string $uri, array $options = []): Response
    {
        return $this->sendRequest('DELETE', $uri, $options);
    }

    /**
     * Sends a HTTP request and returns the response.
     */
    private function sendRequest(string $method, string $uri, array $options = []): Response
    {
        try {
            $response = $this->httpClient->request($method, $uri, $options);

            $json = json_decode($response->getBody()->getContents(), true);

            return new Response(
                response: $json,
                status: $response->getStatusCode(),
            );
        } catch (ClientException $clientException) {
            $response = $clientException->getResponse()->getBody()->getContents();

            $json = json_decode($response, true);

            throw new DockerClientException($json['message']);
        } catch (ConnectException) {
            throw DockerClientException::failedToConnect();
        }
    }
}
