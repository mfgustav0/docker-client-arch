<?php

declare(strict_types=1);

namespace Tests\Feature\Container;

use Modules\Docker\Container\Domain\Interfaces\Repositories\ContainerRepositoryInterface;
use Tests\Fixtures\Container\ContainerFakeRepository;
use Tests\TestCase;

final class StoreContainerTest extends TestCase
{
    public function test_user_can_store_container(): void
    {
        $this->mockRepository();

        $payload = [
            'image' => 'sail-8.3/app',
            'name' => 'sail',
        ];

        $this->postJson('/containers', $payload)
            ->assertCreated();
    }

    public function test_user_cannot_store_container_if_docker_is_any_error(): void
    {
        $this->mockRepository(
            simulateError: true,
        );

        $payload = [
            'image' => 'sail-8.3/app',
            'name' => 'sail',
        ];

        $this->postJson('/containers', $payload)
            ->assertServerError()
            ->assertJsonStructure([
                'error',
            ]);
    }

    public function test_user_cannot_store_container_if_not_send_valid_request(): void
    {
        $this->mockRepository();

        $this->postJson('/containers')
            ->assertJsonValidationErrors([
                'image',
                'name',
            ]);
    }

    public function mockRepository(bool $simulateError = false): void
    {
        $this->app->singleton(
            ContainerRepositoryInterface::class,
            fn() => new ContainerFakeRepository(
                $simulateError,
            ),
        );
    }
}
