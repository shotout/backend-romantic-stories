<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Models\Schedule;
use App\Jobs\GenerateTimer;
use Illuminate\Http\Request;
use App\Jobs\GenerateTimerAds;
use App\Http\Controllers\Controller;
use App\Models\Subscription;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = User::with('icon','category','get_avatar_male','get_avatar_female','theme','language','schedule','subscription')
            ->find(auth('sanctum')->user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function update(Request $request)
    {
        $user = User::find(auth('sanctum')->user()->id);

        if ($request->has('icon') && $request->icon != '') {
            $user->icon_id = $request->icon;
            $user->update();
        }

        if ($request->has('name') && $request->name != '') {
            $user->name = $request->name;
            $user->update();
        }

        if ($request->has('gender') && $request->gender != '') {
            $user->gender = $request->gender;
            $user->update();
        }

        if ($request->has('avatar_male') && $request->avatar_male != '') {
            $user->avatar_male = $request->avatar_male;
            $user->update();
        }
        if ($request->has('avatar_female') && $request->avatar_female != '') {
            $user->avatar_female = $request->avatar_female;
            $user->update();
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $user->category_id = $request->category_id;
            $user->update();
        }
        
        if ($request->has('language_id') && $request->language_id != '') {
            $user->language_id = $request->language_id;
            $user->update();
        }

        if ($request->has('fcm_token') && $request->fcm_token != '') {
            $user->fcm_token = $request->fcm_token;
            $user->update();
        }

        if ($request->has('purchasely_id') && $request->purchasely_id != '') {
            $user->purchasely_id = $request->purchasely_id;
            $user->update();
        }

        // enable or disable notif
        if ($request->has('notif_enable') && $request->notif_enable != '') {
            $user->notif_enable = $request->notif_enable ;
            $user->update();
        }

        // enable or disable notif ads
        if ($request->has('notif_ads_enable') && $request->notif_ads_enable != '') {
            $user->notif_ads_enable = $request->notif_ads_enable ;
            $user->update();
        }

        // reset user notif counter
        if ($request->has('notif_count')) {
            $user->notif_count = 0;
            $user->update();
        }

        // reset notif ads count
        if ($request->has('notif_ads_count')) {
            $user->notif_ads_count = 0;
            $user->update();
        }

        // new user
        $data = User::with('icon','category','get_avatar_male','get_avatar_female','theme','language','schedule','subscription')
            ->find(auth('sanctum')->user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }
}