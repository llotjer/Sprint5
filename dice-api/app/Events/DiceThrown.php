<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiceThrown
{
    use Dispatchable, SerializesModels;

    public $userId;
    public $diceResults;
    public $isVictory;

    public function __construct(int $userId, array $diceResults, bool $isVictory)
    {
        $this->userId = $userId;
        $this->diceResults = $diceResults;
        $this->isVictory = $isVictory;
    }
}
