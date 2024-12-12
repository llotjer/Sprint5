<?php

namespace App\Listeners;

use App\Events\DiceThrown;
use App\Models\Game;
use App\Models\Player;

class DiceThrownListener
{
    public function handle(DiceThrown $event)
    {
        Game::create(
        [
            'player_id' => $event->userId,
            'dice_1' => $event->diceResults[0],
            'dice_2' => $event->diceResults[1],
            'is_victory' => $event->isVictory,
        ]);

        $player = Player::find($event->userId);

        $player->increment('games');

        if ($event->isVictory) 
        {
            $player->increment('victories');
            $player->percentage = ($player->victories / $player->games) * 100;

        } else
        {
            $player->percentage = 0;
        }

        $player->save();
    }
}
