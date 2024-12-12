<?php

namespace Tests\Feature;

use App\Events\DiceThrown;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class DiceThrownTest extends TestCase
{
    #[Test]
    public function test_dice_thrown_event_constructs_correctly()
    {
        $userId = 1;
        $diceResults = [3, 4];
        $isVictory = true;

        $event = new DiceThrown($userId, $diceResults, $isVictory);

        $this->assertEquals($userId, $event->userId);
        $this->assertEquals($diceResults, $event->diceResults);
        $this->assertTrue($event->isVictory);
    }
}
