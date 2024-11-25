<?php

declare(strict_types=1);

namespace App\Docker\Common\Infrastructure\Exceptions;

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

}
