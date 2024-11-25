<?php

declare(strict_types=1);

namespace App\Docker\Common\Domain\Interfaces\Http;

use App\Docker\Common\Domain\Entities\Response;

interface DockerClientInterface
{
    /**
     * Perform a GET request to the Docker API.
     */
    public function get(string $uri, array $options = []): Response;

    /**
     * Perform a POST request to the Docker API.
     */
    public function post(string $uri, array $options = []): Response;

    /**
     * Perform a PUT request to the Docker API.
     */
    public function put(string $uri, array $options = []): Response;

    /**
     * Perform a DELETE request to the Docker API.
     */
    public function delete(string $uri, array $options = []): Response;
}
