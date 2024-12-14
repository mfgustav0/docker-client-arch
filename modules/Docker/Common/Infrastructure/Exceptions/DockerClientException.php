<?php

declare(strict_types=1);

namespace Modules\Docker\Common\Infrastructure\Exceptions;

use RuntimeException;

final class DockerClientException extends RuntimeException
{
    /**
     * Creates an exception for an invalid Docker client provider.
     */
    public static function wrongClientProvider(): static
    {
        return new static('The specified Docker client provider is invalid or unsupported.');
    }

    /**
     * Creates an exception for failure to connect to the Docker daemon.
     */
    public static function failedToConnect(): static
    {
        return new static(
            "Failed to connect to the Docker daemon.\n" .
            "Possible causes:\n" .
            "- Docker is not running.\n" .
            "- The specified URL or port is incorrect.\n" .
            "- Network issues or firewall settings are blocking the connection.\n" .
            "Suggestions:\n" .
            "- Ensure Docker is installed and running.\n" .
            "- Verify the URL and port configuration (e.g., localhost:2375).\n" .
            "- Check network and firewall settings.\n" .
            "For more details, refer to the Docker documentation: https://docs.docker.com/config/daemon/\n",
        );
    }
}
