<?php

namespace Tests\Feature;

use App\Events\DiceThrown;
use App\Listeners\DiceThrownListener;
use App\Models\Player;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DiceThrownListenerTest extends TestCase
{
    #[Test]
    public function test_listener_creates_game_and_updates_player_stats()
    {
        $player = Player::create(
        [
            'id'        => 1,
            'nickname'  => 'tester',
            'victories' => 0
        ]);

        $event = new DiceThrown($player->id, [5, 2], true);
        $listener = new DiceThrownListener();

        $listener->handle($event);

        $this->assertDatabaseHas('games', 
        [
            'player_id' => $player->id,
            'dice_1' => 5,
            'dice_2' => 2,
            'is_victory' => true,
        ]);

        $player->refresh();
        $this->assertEquals(1, $player->games);
        $this->assertEquals(1, $player->victories);
    }

    //--------------------------------------------------------------------------------------------------------

    #[Test]
    public function test_listener_creates_game_without_victory()
    {
        $player = Player::create(
        [
            'id'        => 1,
            'nickname'  => 'tester',
            'victories' => 0
        ]);

        $event = new DiceThrown($player->id, [2, 3], false);
        $listener = new DiceThrownListener();

        $listener->handle($event);

        $this->assertDatabaseHas('games', 
        [
            'player_id' => $player->id,
            'dice_1' => 2,
            'dice_2' => 3,
            'is_victory' => false,
        ]);

        $player->refresh();
        $this->assertEquals(1, $player->games);
        $this->assertEquals(0, $player->victories);
    }
}
