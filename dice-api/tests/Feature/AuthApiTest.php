<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    #[Test]
    public function test_user_can_login()
    {
        $user = User::factory()->create(
        [
            'password' => bcrypt('12345678')
        ]);
    
        $response = $this->postJson('/login', 
        [
            'email' => $user->email,
            'password' => '12345678',
        ], 
        ['Content-Type' => 'application/json']);

        $token = $user->createToken('API Token')->accessToken;

        $this->assertNotNull($token, 'Token should be generated on login');

        $response->assertOk();

        return $token;
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_user_can_logout()
    {
        $token = $this->test_user_can_login();

        $logoutResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
                                ->postJson('/logout');

        $logoutResponse->assertOk();

    }
}

