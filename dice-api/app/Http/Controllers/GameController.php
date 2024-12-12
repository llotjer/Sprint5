<?php

namespace App\Http\Controllers;

use App\Events\DiceThrown;
use App\Models\Player;

class GameController extends Controller
{
    public function store(int $userId)
    {
        $dice1 = rand(1, 6);
        $dice2 = rand(1, 6);
        $sumDices = $dice1 + $dice2;
        $isVictory = $sumDices === 7;

        $player = Player::findOrFail($userId);

        $gameCount = $player->games()->count();

        event(new DiceThrown($userId, [$dice1, $dice2], $isVictory));

        $gameCountNew = $player->games()->count();

        return $gameCountNew === ($gameCount + 1);
    }
}
