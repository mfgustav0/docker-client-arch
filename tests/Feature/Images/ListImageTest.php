<?php

declare(strict_types=1);

namespace Tests\Feature\Images;

use Modules\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use Tests\Fixtures\Images\ImageFakeRepository;
use Tests\TestCase;

final class ListImageTest extends TestCase
{
    public function test_user_can_list_all_the_images(): void
    {
        $this->mockRepository();

        $this->getJson('/images?all=true')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'parentId',
                        'repositoryTags',
                        'repositoryDigests',
                        'created',
                        'size',
                        'virtualSize',
                        'labels',
                        'dockerVersion',
                        'architecture',
                        'os',
                        'osVersion',
                        'config',
                        'rootFs',
                        'graphDriver',
                        'author',
                    ],
                ],
            ]);
    }

    public function test_user_cannot_list_the_images_if_docker_is_any_error(): void
    {
        $this->mockRepository(
            simulateError: true,
        );

        $this->getJson('/images?all=true')
            ->assertServerError()
            ->assertJsonStructure([
                'error',
            ]);
    }

    public function mockRepository(bool $simulateError = false): void
    {
        $this->app->singleton(
            ImageRepositoryInterface::class,
            fn() => new ImageFakeRepository(
                $simulateError,
            ),
        );
    }
}
