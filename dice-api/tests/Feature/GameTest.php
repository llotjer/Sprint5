<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Player;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;


class GameTest extends TestCase
{
    #[Test]
    public function test_game_can_be_created()
    {

        $player = Player::create(
        [
            'id'        => 1,
            'nickname'  => 'tester',
            'victories' => 0
        ]);

        $game = Game::create(
        [
            'player_id'  => 1,
            'dice_1'     => 4,
            'dice_2'     => 3,
            'is_victory' => true
        ]);

        $this->assertDatabaseHas('games', 
        [
            'player_id' => 1,
            'dice_1' => 4,
            'dice_2' => 3,
            'is_victory' => true
        ]);
    }
}
