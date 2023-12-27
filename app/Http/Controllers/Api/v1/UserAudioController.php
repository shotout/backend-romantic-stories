<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserAudio;

class UserAudioController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate(['play' => 'required']);

        $ua = UserAudio::where('story_id', $id)
            ->where('user_id', auth('sanctum')->user()->id)
            ->first();

        if (!$ua) $ua = new UserAudio;
        $ua->user_id = auth('sanctum')->user()->id;
        $ua->story_id = $id;
        $ua->play = $ua->play + $request->play;
        $ua->save();

        return response()->json([
            'status' => 'success',
            'data' => $ua
        ], 200);
    }
}