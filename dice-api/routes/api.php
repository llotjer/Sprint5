<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working!']);
});

//--------------------------------------------------------------------------------------------------------------

Route::post('/login', [AuthenticationController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthenticationController::class, 'logout']);

//--------------------------------------------------------------------------------------------------------------

Route::post('/register', [UserController::class, 'register']);
Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->middleware(['auth:api']);

//--------------------------------------------------------------------------------------------------------------

Route::prefix('players')->middleware(['auth:api'])->group(function() {
    Route::post('/', [PlayerController::class, 'store']); //registra un jugador nou.
    Route::post('/{id}/games', [PlayerController::class, 'play']); //un jugador/a específic realitza una tirada dels daus.
    Route::get('/{id}/games', [PlayerController::class, 'getPlayerGames']); //retorna el llistat de jugades per un jugador/a.
    Route::put('/{id}', [PlayerController::class, 'update']); // modifica el nom (nickname) del jugador/a.
    Route::get('/', [PlayerController::class, 'show']); //retorna el llistat de tots els jugadors/es del sistema amb el seu percentatge mitjà d’èxits
    Route::delete('/{id}/games', [PlayerController::class, 'destroyGames']); //elimina les tirades del jugador/a.
    Route::get('/ranking', [PlayerController::class, 'getRanking']); //retorna el rànquing mitjà de tots els jugadors/es del sistema (el percentatge mitjà d’èxits).
    Route::get('/ranking/loser', [PlayerController::class, 'getLoser']); //retorna el jugador/a amb pitjor percentatge d’èxit.
    Route::get('/ranking/winner', [PlayerController::class, 'getWinner']); //retorna el jugador/a amb millor percentatge d’èxit.
});