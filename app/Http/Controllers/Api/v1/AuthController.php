<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'avatar_male' => 'required',
            'avatar_female' => 'required',
            'theme_id' => 'required',
            'language_id' => 'required',
        ]);

        $user = new User;
        $user->icon_id = 1;
        $user->category_id = $request->category_id;
        $user->theme_id = $request->theme_id;
        $user->language_id = $request->language_id;
        if ($request->has('name') && $request->name != '') $user->name = $request->name;
        if ($request->has('gender') && $request->gender != '') $user->gender = $request->gender;
        if ($request->has('avatar_male') && $request->avatar_male != '') $user->avatar_male = $request->avatar_male;
        if ($request->has('avatar_female') && $request->avatar_female != '') $user->avatar_female = $request->avatar_female;
        $user->save();

        return response()->json([
            'status' => 'success',
            // 'token' => $token,
            'data' => $user
        ], 201); 
    }
}