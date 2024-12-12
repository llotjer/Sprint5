<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PlayerApiTest extends TestCase
{
    #[Test]
    public function test_a_player_can_be_created()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->postJson("/players", 
        [
            'nickname' => 'Test Nickname',
        ], 
        [   
            'Content-Type'  => 'application/json'
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('players', 
        [
            'nickname' => 'Test Nickname',
        ]);

    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_get_all_players_with_their_percentage()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->get("/players");

        $response->assertOk();
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_get_all_games_from_a_player()
    {
        $user = User::factory()->create();

        $player = Player::create(
        [
            'player_id' => $user->id,
            'nickname'  => 'tester'
        ]);

        Passport::actingAs($user);

        $response = $this->get("/players/$player->id/games");

        $response->assertOk();
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_change_nickname_from_a_player()
    {
        $user = User::factory()->create(
        [
            'role' => 'admin'
        ]);

        $player = Player::create(
        [
            'player_id' => $user->id,
            'nickname'  => 'tester'
        ]);

        Passport::actingAs($user);

        //dump($user);
        //dump($player);

        $response =  $this->putJson("/players/$player->id",
        [
            'nickname' => 'testing'
        ], 
        [
            'Content-Type' => 'application/json'
        ]);

        //dump($player);
        //dd($response);

        $response->assertOk();
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_a_player_can_play()
    {
        $user = User::factory()->create();

        $player = Player::create(
        [
            'player_id' => $user->id,
            'nickname'  => 'tester'
        ]);

        Passport::actingAs($user);

        $response = $this->post("/players/$player->id/games", 
        [
            'Content-Type'  => 'application/json'
        ]);

        $response->assertOk();
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_all_games_from_a_player_can_be_deleted()
    {
        $user = User::factory()->create(
        [
            'role' => 'admin'
        ]);

        $player = Player::create(
        [
            'player_id' => $user->id,
            'nickname'  => 'tester'
        ]);

        $player->games = 3;

        //dd($player);

        Passport::actingAs($user);

        $response = $this->delete("/players/$player->id/games");

        $response->assertOk();
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_a_ranking_can_be_retrived()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->get("/players/ranking", 
        [
            'Content-Type' => 'application/json'
        ]);

        $response->assertOk();
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_a_winner_can_be_retrived()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->get("/players/ranking/winner", 
        [
            'Content-Type' => 'application/json'
        ]);

        //dd($response);

        $response->assertOk();
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_a_loser_can_be_retrived()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->get("/players/ranking/loser", 
        [
            'Content-Type' => 'application/json'
        ]);

        $response->assertOk();
    }

}