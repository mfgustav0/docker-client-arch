<?php

declare(strict_types=1);

namespace Tests\Feature\Container;

use Modules\Docker\Container\Domain\Interfaces\Repositories\ContainerRepositoryInterface;
use Tests\Fixtures\Container\ContainerFakeRepository;
use Tests\TestCase;

final class ListContainerTest extends TestCase
{
    public function test_user_can_list_all_the_containers(): void
    {
        $this->mockRepository();

        $this->getJson('/containers?all=true')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'names',
                        'image',
                        'imageId',
                        'command',
                        'created',
                        'state',
                        'status',
                        'ports',
                        'labels',
                        'sizeRw',
                        'sizeRootFs',
                        'hostConfig',
                        'networkSettings',
                        'mounts',
                    ],
                ],
            ]);
    }

    public function test_user_cannot_list_the_containers_if_docker_is_any_error(): void
    {
        $this->mockRepository(
            simulateError: true,
        );

        $this->getJson('/containers?all=true')
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
