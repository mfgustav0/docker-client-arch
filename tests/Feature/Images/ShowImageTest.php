<?php

declare(strict_types=1);

namespace Tests\Feature\Container;

use Modules\Docker\Image\Domain\Interfaces\Repositories\ImageRepositoryInterface;
use Tests\Fixtures\Images\ImageFakeRepository;
use Tests\TestCase;

final class ShowImageTest extends TestCase
{
    public function test_user_can_show_image(): void
    {
        $this->mockRepository();

        $this->getJson('/images/8.3-mock')
            ->assertOk()
            ->assertJsonStructure([
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
            ]);
    }

    public function test_user_cannot_show_the_image_if_not_exists(): void
    {
        $this->mockRepository();

        $this->getJson('/images/wrong-image')
            ->assertServerError()
            ->assertJson([
                'error' => 'No such image: wrong-image',
            ]);
    }

    public function test_user_cannot_show_the_image_if_docker_is_any_error(): void
    {
        $this->mockRepository(
            simulateError: true,
        );

        $this->getJson('/images/8.3-mock')
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
