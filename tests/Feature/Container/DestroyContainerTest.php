<?php

declare(strict_types=1);

namespace Tests\Feature\Container;

use Modules\Docker\Container\Domain\Interfaces\Repositories\ContainerRepositoryInterface;
use Tests\Fixtures\Container\ContainerFakeRepository;
use Tests\TestCase;

final class DestroyContainerTest extends TestCase
{
    public function test_user_can_destroy_the_container(): void
    {
        $this->mockRepository();

        $this->deleteJson('/containers/mocked-id-123')
            ->assertNoContent();
    }

    public function test_user_cannot_destroy_container_if_docker_is_any_error(): void
    {
        $this->mockRepository(
            simulateError: true,
        );

        $this->deleteJson('/containers/mocked-id-123')
            ->assertServerError()
            ->assertJsonStructure([
                'error',
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
