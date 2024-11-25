<?php

declare(strict_types=1);

namespace App\Docker\Common\Domain\Entities;

final readonly class Response
{
    /**
     * Create new instance
     */
    public function __construct(
        public ?array $response,
        public int $status,
    ) {}

    /**
     * Check if is status
     */
    public function isStatus(int $status): bool
    {
        return $this->status === $status;
    }
}
