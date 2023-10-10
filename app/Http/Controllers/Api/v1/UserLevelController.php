<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Level;

class UserLevelController extends Controller
{
    public function store()
    {
        $user = User::with('user_level')->findOrFail(auth('sanctum')->user()->id);

        // add 1 point
        $user->user_level->point++;
        $user->user_level->update();

        // check level
        $level = Level::where('value', '<=', $user->user_level->point)
            ->where('value', '>=', $user->user_level->point)
            ->first();

        if ($level && $level->id != $user->user_level->level_id) {
            $user->user_level->level_id = $level->id;
            $user->user_level->update();

            $user = User::with('user_level')->findOrFail(auth('sanctum')->user()->id);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }
}