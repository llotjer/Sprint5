<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    /** @use HasFactory<\Database\Factories\UserFactory> */

    protected $fillable = ['player_id', 'dice_1', 'dice_2', 'is_victory'];
}
