<?php

declare(strict_types=1);

namespace Tests\Feature\Container;

use Modules\Docker\Container\Domain\Interfaces\Repositories\ContainerRepositoryInterface;
use Tests\Fixtures\Container\ContainerFakeRepository;
use Tests\TestCase;

final class StopContainerTest extends TestCase
{
    public function test_user_can_stop_the_container(): void
    {
        $this->mockRepository();

        $this->putJson('/containers/mocked-id-123/stop')
            ->assertNoContent();
    }

    public function test_user_cannot_stop_container_if_docker_is_any_error(): void
    {
        $this->mockRepository(
            simulateError: true,
        );

        $this->putJson('/containers/mocked-id-123/stop')
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
