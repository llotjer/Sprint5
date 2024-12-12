<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    #[Test]
    public function test_user_can_be_created()
    {

        $response = $this->postJson('/register', 
        [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123'
        ], 
        ['Content-Type' => 'application/json']);

        //$response->dump();

        $response->assertOk();
                
        $this->assertDatabaseHas('users', 
        [
            'email' => 'testuser@example.com',
        ]);
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_user_role_can_be_updated()
    {

        $userPlayer = User::factory()->create(
        [
            'role' => 'player'
        ]);

        $userAdmin = User::factory()->create(
        [
            'role' => 'admin'
        ]);
        
        Passport::actingAs($userAdmin);

        $response = $this->putJson("/users/$userPlayer->id/role",
        [
            'role' => 'admin'
        ], 
        ['Content-Type' => 'application/json']);

        $response->assertOk();
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_can_register_multiple_anonymous()
    {
        $response1 = $this->postJson('/register', 
        [
            'email'    => 'anonymous1@test.com',
            'password' => 'password123'
        ], 
        ['Content-Type' => 'application/json']);

        //$response1->dump();

        $response1->assertOk();

        $response2 = $this->postJson('/register', 
        [
            'email'    => 'anonymous2@test.com',
            'password' => 'password123'
        ], 
        ['Content-Type' => 'application/json']);

        //$response2->dump();

        $response2->assertOk();

        $this->assertDatabaseHas('users', 
        [
            'name'  => 'Anonymous',
            'email' => 'anonymous1@test.com',
        ]);

        $this->assertDatabaseHas('users', 
        [
            'name'  => 'Anonymous',
            'email' => 'anonymous2@test.com',
        ]);
    }
}

