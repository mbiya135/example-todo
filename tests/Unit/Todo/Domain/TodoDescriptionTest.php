<?php

namespace Tests\Unit\Todo\Domain;

use App\Todo\Domain\TodoDescription;
use Tests\TestCase;

class TodoDescriptionTest extends TestCase
{
    private const DESCRIPTION = 'Description';

    /**
     * Assert creation todo
     * @test
     */
    public function can_create_from_string(): void
    {
        $todoDescription = TodoDescription::createFromString(self::DESCRIPTION);
        $this->assertTrue(($todoDescription->sameAs($todoDescription::createFromString(self::DESCRIPTION))));
        $this->assertFalse(($todoDescription->sameAs($todoDescription::createFromString('test'))));
    }
}
