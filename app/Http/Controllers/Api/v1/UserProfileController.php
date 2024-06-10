<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Story;
use App\Jobs\UserPool;
use App\Models\Schedule;
use App\Models\UserAudio;
use App\Jobs\GenerateTimer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Jobs\GenerateTimerAds;
use App\Models\CollectionStory;
use App\Http\Controllers\Controller;
use App\Models\UserTrack;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = User::with([
            'user_level',
            'icon',
            'category.image' => fn($q) => $q->where('model',auth('sanctum')->user()->type),
            'get_avatar_male.image' => fn($q) => $q->where('model',auth('sanctum')->user()->type),
            'get_avatar_female.image' => fn($q) => $q->where('model',auth('sanctum')->user()->type),
            'theme',
            'language',
            'schedule',
            'subscription'
        ])
            ->find(auth('sanctum')->user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function update(Request $request)
    {
        $user = User::find(auth('sanctum')->user()->id);

        if ($request->has('level') && $request->level != '') {
            $user->user_level->level_id = $request->level;
            $user->update();
        }

        if ($request->has('icon') && $request->icon != '') {
            $user->icon_id = $request->icon;
            $user->update();
        }

        if ($request->has('name')) {
            $user->name = $request->name;
            $user->update();
        }

        if ($request->has('gender')) {
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

            // update user pool
            UserPool::dispatch($user)->onQueue(env('SUPERVISOR'));
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

        // audio limit
        // if ($request->has('audio_unlimit') && $request->audio_unlimit != '') {
        //     $user->subscription->is_audio = 1;
        //     $user->subscription->audio_unlimit = $request->audio_unlimit;
        //     $user->subscription->update();
        // }
        if ($request->has('is_audio') && $request->is_audio != '') {
            $user->subscription->is_audio = $request->is_audio;
            $user->subscription->audio_limit = $request->audio_limit;
            $user->subscription->audio_take = 0;
            $user->subscription->update();
        }
        if ($request->has('audio_take') && $request->audio_take != '') {
            if ($user->subscription->is_audio) {
                if ($user->subscription->audio_take < $user->subscription->audio_limit) {
                    $user->subscription->audio_take++;
                    $user->subscription->update();

                    if ($request->has('story_id') && $request->story_id != '') {
                        $ua = UserAudio::where('user_id', $user->id)->where('story_id', $request->story_id)->first();
                        if (!$ua) $ua = new UserAudio;
                        $ua->user_id = $user->id;
                        $ua->story_id = $request->story_id;
                        $ua->save();

                        // user tracking
                        $ut = UserTrack::where('user_id', $user->id)->first();
                        if (!$ut) $ut = new UserTrack;
                        $ut->user_id = $user->id;
                        $ut->listen_story++;
                        $ut->save();
                    }
                }

                if ($user->subscription->audio_take == $user->subscription->audio_limit) {
                    $user->subscription->is_audio = 0;
                    $user->subscription->update();
                }
            }
        }

        // story limit
        if ($request->has('story_id') && $request->story_id != '') {
            if ($request->has('expire') && $request->expire != '') {
                $story = Story::find($request->story_id);
                if ($story) {
                    $cs = CollectionStory::where('user_id', auth()->user()->id)
                        ->where('story_id', $story->id)
                        ->first();

                    if (!$cs) $cs = new CollectionStory;
                    $cs->user_id = auth()->user()->id;
                    $cs->story_id = $story->id;

                    if ($request->expire == 0) {
                        $cs->expire = null;
                    } else if ($request->expire == 1) {
                        $cs->expire = now()->setTimezone($user->schedule->timezone)->addHour(12);
                    } else {
                        $cs->expire = now()->setTimezone($user->schedule->timezone)->addDay($request->expire);
                    }
                    $cs->save();
                }
            }
        }

        // membership
        if ($request->has('is_member') && $request->is_member != '') {
            if ($request->is_member == 1) $user->is_member = 0;
            else $user->is_member = 1;
            $user->update();

            $user->subscription->plan_id = $request->is_member;
            $user->subscription->type = $request->is_member;
            if ($request->is_member == 1) {
                $user->subscription->started = Carbon::now();
                $user->subscription->renewal = Carbon::now()->addDay(3);
            } else {
                $user->subscription->started = Carbon::now();
                $user->subscription->renewal = Carbon::now()->addYear(1);
            }
            $user->subscription->update();
        }

        // new user
        $data = User::with([
            'user_level',
            'icon',
            'category.image' => fn($q) => $q->where('model',auth('sanctum')->user()->type),
            'get_avatar_male.image' => fn($q) => $q->where('model',auth('sanctum')->user()->type),
            'get_avatar_female.image' => fn($q) => $q->where('model',auth('sanctum')->user()->type),
            'theme',
            'language',
            'schedule',
            'subscription'
        ])
            ->find(auth('sanctum')->user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function tracking(Request $request)
    {
        $request->validate([
            'flag' => 'required',
            'value' => 'required'
        ]);

        $user_track = UserTrack::where('user_id', auth('sanctum')->user()->id)->first();
        if (!$user_track) $user_track = new UserTrack;

        if ($request->flag == 'read') {
            $user_track->{'read_'.$request->value.'_story'} = 1;
        }
        if ($request->flag == 'listen') {
            $user_track->{'listen_'.$request->value.'_story'}  = 1;
        }
        if ($request->flag == 'time') {
            $user_track->time_usage = $user_track->time_usage + $request->value;
        }
        
        $user_track->user_id = auth('sanctum')->user()->id;
        $user_track->save();

        return response()->json([
            'status' => 'success',
            'data' => $user_track
        ], 200);
    }
}