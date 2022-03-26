<?php

namespace Tests\Unit\Todo\Domain;

use App\Todo\Domain\TodoId;
use Tests\TestCase;

class TodoIdTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * Assert creation todo
     * @test
     */
    public function can_create_from_string(): void
    {
        $todoId = TodoId::createFromString(self::UUID);
        $this->assertTrue(($todoId->sameAs(TodoId::createFromString(self::UUID))));
        $this->assertFalse(($todoId->sameAs(TodoId::generateUuid())));
    }
}
