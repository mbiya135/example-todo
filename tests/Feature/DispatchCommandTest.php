<?php

namespace Tests\Feature;

use Tests\TestCase;

class DispatchCommandTest extends TestCase
{
    private const UUID = '88cffeec-8c17-475b-8db0-f4092c27d011';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->postJson(
            '/api/user',
            [
                'user_id' => self::UUID,
                'user_name' => 'test',
                'user_email' => 'test@test.test',
                'user_password' => '1234',
            ]
        );

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }
}
