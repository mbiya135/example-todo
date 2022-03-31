<?php

namespace Tests\Unit\User\Infrastructure;

use App\Exceptions\DomainInvalidArgumentException;
use App\User\Application\AddUser;
use App\User\Application\AddUserHandler;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\User;
use App\User\Domain\UserEmail;
use App\User\Domain\UserId;
use App\User\Domain\UserName;
use App\User\Domain\UserPassword;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    private const UUID = '93cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * @test
     */
    public function can_get_aggregate_root(): void
    {
        $repository = new \App\User\Infrastructure\Repository\UserRepository();
        $this->assertNull($repository->get(UserId::createFromString(self::UUID)));
    }
}
