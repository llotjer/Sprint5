<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(
        [
            'name'     => 'nullable|string|min:4',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'email_verified_at' => now(),
        ]);

        if ($request->filled('name') && User::where('name', $request->name)->exists()) {
            return response()->json(['error' => 'The name has already been taken.'], 422);
        }

        $user = new User();
        $user->name     = $request->name ?? 'Anonymous';
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'success Register'], 200);
    }

    //--------------------------------------------------------------------------------------------------------

    public function show(int $id)
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') 
        {
            $userToShow = User::findOrFail($id);
            return response()->json(
            [
                'message' => 'User redeemed successfully',
                'user' => $userToShow
            ], 200);
            
        }else 
        {
            return response()->json(['message' => 'Not enough permissions.'], 403);
        }

    }

    //--------------------------------------------------------------------------------------------------------

    public function updateRole(Request $request, int $id)
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') 
        {
            $userToUpdate       = User::findOrFail($id);
            $userToUpdate->role = $request->role;
            $userToUpdate->save();

        } else 
        {
            return response()->json(['message' => 'Not enough permissions.'], 403);
        }
<<<<<<< Updated upstream
        
=======

>>>>>>> Stashed changes
        return response()->json(['message' => 'Role updated successfully'], 200);
    }
    
    //--------------------------------------------------------------------------------------------------------

    public function destroy(int $id)
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') 
        {
            $userToDelete = User::findOrFail($id);
            $userToDelete->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);

        }else 
        {
            return response()->json(['message' => 'Not enough permissions.'], 403);
        }

    }
}