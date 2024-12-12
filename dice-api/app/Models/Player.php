<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{

    protected $fillable = ['id', 'nickname', 'victories'];

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}