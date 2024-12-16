<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        //dd($user);

        $request->validate(
        [
            'nickname' => 'required|string|min:4'
        ]);

        Player::create(
        [
            'id'=> $user->id,
            'nickname' => $request->nickname
        ]);

        return response()->json(
        [
            'id' => $user->id, 
            'message' => 'Player ' . $request->nickname . ' successfully registered!'
        ], 200);
    }

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function show()
    {
        $playersPercentage = $this->getPercentage();

        //dd($percentage);

        return response()->json([$playersPercentage]);
    }
    
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function update(Request $request, int $id)
    {
        $player = Player::findOrFail($id);

        $user = Auth::user();

        //dd(Auth::user());

        //dd($request->all());

        if($user && $user->role === 'admin')
        {
            $player->nickname = $request->nickname;

            $player->save();

            return response()->json(['message' => 'Nickname successfully updated. New nickname : ' . $player->nickname], 200);

        } else
        {
            return response()->json(['message' => 'Not enough permissions.'], 403);
        }
    }
    
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    public function destroyGames(int $id)
    {
        $user = Auth::user();
        
        if($user && $user->role === 'admin')
        {
            $player = Player::findOrFail($id);

            $player->games()->delete();

            return response()->json(['message' => 'Games successfully deleted.'], 200);

        } else
        {
            return response()->json(['message' => 'Not enough permissions.'], 403);
        }
    }
    
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function getPlayerGames(int $id)
    {
        $player = Player::findOrFail($id);

        $gameInfo = [];

        foreach(Game::all() as $game)
        {
            if($game->player_id === $id)
            {
                $gameInfo[] = 
                [
                    'player' => $player->nickname,
                    'game'   => $game->id,
                    'dice1'  => $game->dice_1,
                    'dice2'  => $game->dice_2,
                ];
            }
            
        }
        
        return $gameInfo;
    }
    
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function play(int $id)
    {
        $gameController = new GameController();

        $user = Auth::user();

        $player = Player::findOrFail($user->id);

        if($user && $user->id === $id)
        {
            if($gameController->store($id))
            {
                $answer = 'You loose...';

                $playerLastGame = $player->games()->latest('created_at')->first();

                if($playerLastGame->is_victory)
                {
                    $answer = 'YOU WIN!';
                }

                return response()->json(
                [
                    'player_id' => $id,
                    'dice_1'    => $playerLastGame->dice_1,
                    'dice_2'    => $playerLastGame->dice_2,
                    'is_victory'=> $answer,
                    'message'   => 'Game registered successfully!'
                ], 200);

            } else
            {
                return response()->json(
                [
                    'player_id' => $id, 
                    'message'   => 'Some error occurred registering the game'
                ]);
            }

        } else
        {
            return response()->json(['message' => "You can only play as: $player->nickname."], 403);
        }
    
    }
    
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function getPercentage()
    {
        $percentages = [];

        $players = Player::all();

        foreach($players as $player)
        {
            $percentages[] = ['name' => $player->nickname, 'percentage' => $player->percentage];
        }

        return $percentages;
    }

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function getRanking()
    {
        $playersPercentage = $this->getPercentage();

        usort($playersPercentage, function ($a, $b) 
        {
            return $b['percentage'] <=> $a['percentage'];
        });

        return $playersPercentage;
    }

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function getLoser()
    {
        $players = Player::all();
        $player1 = $players->first();
        $player2 = $players->last();

        if(Player::count() === 2 && $player1->percentage === $player2->percentage)
        {
            return response()->json("There is a draw between $player1->nickname and $player2->nickname.", 200);

        } else
        {
            $loser = Player::orderBy('percentage')->first();

            //dd($loser);

            return response()->json($loser, 200);

        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function getWinner()
    {
        $players = Player::all();
        $player1 = $players->first();
        $player2 = $players->last();

        if(Player::count() === 2 && $player1->percentage === $player2->percentage)
        {
            return response()->json("There is a draw between $player1->nickname and $player2->nickname.", 200);

        } else
        {
            $winner = Player::orderByDesc('percentage')->first();

            //dd($winner);

            return response()->json($winner, 200);
        }
    }
}
