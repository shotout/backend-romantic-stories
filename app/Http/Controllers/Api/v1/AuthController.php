<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use App\Models\User;
use App\Jobs\UserPool;
use App\Models\Schedule;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Models\UserTheme;

class AuthController extends Controller
{
    public function check(Request $request)
    {
        $request->validate(['device_id' => 'required']);

        $user = User::with('level','icon','category','get_avatar_male','get_avatar_female','theme','language','schedule','subscription')
            ->where('device_id', $request->device_id)
            ->first();

        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'data' => $user
            ], 200); 
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'device not register'
        ], 400); 
    }

    public function register(Request $request)
    {
        // validate -------------
        $request->validate([
            'device_id' => 'required',
            'category_id' => 'required',
            'avatar_male' => 'required',
            'avatar_female' => 'required',
            'theme_id' => 'required',
            'language_id' => 'required',
        ]);
        // ---------------------

        // check device id ------------------
        $isRegister = User::where('device_id', $request->device_id)->first();
        if ($isRegister) {
            return response()->json([
                'status' => 'failed',
                'message' => 'device has register'
            ], 400); 
        }
        // -----------------------------

        // register user --------------------------
        $user = DB::transaction(function () use ($request) {    
            $user = new User;
            $user->icon_id = 1;
            $user->category_id = $request->category_id;
            $user->language_id = $request->language_id;

            if ($request->has('name') && $request->name != '') $user->name = $request->name;
            if ($request->has('gender') && $request->gender != '') $user->gender = $request->gender;
            if ($request->has('avatar_male') && $request->avatar_male != '') $user->avatar_male = $request->avatar_male;
            if ($request->has('avatar_female') && $request->avatar_female != '') $user->avatar_female = $request->avatar_female;

            $user->device_id = $request->device_id;
            if ($request->has('fcm_token') && $request->fcm_token) $user->fcm_token = $request->fcm_token;
            if ($request->has('purchasely_id') && $request->purchasely_id) $user->purchasely_id = $request->purchasely_id;
            $user->save();

            // custome theme ---------
                $theme = Theme::find($request->theme_id);
                if ($theme) {
                    $ut = new UserTheme;
                    $ut->user_id = $user->id;
                    $ut->theme_id = $theme->id;
                    $ut->name = $theme->name;
                    $ut->text_color = $theme->text_color;
                    $ut->font_size = $theme->font_size;
                    $ut->font_family = $theme->font_family;
                    $ut->bg_color = $theme->bg_color;
                    $ut->theme_color = $theme->theme_color;
                    $ut->save();
                }
            // ----------------------

            // subscription ---------
                $sub = new Subscription;
                $sub->user_id = $user->id;
                $sub->plan_id = 1;
                $sub->started = now();
                $sub->renewal = Carbon::now()->addDay(3);
                $sub->save();
            // ----------------------

            // schedule ------------
                $schedule = new Schedule;
                $schedule->user_id = $user->id;

                if ($request->has('timezone')) $schedule->timezone = $request->timezone;
            
                if ($request->has('anytime') && $request->anytime != '') {
                    $schedule->anytime = true;
                    $schedule->often = 6;
                    $schedule->start = '08:00';
                    $schedule->end = '22:00';
                } else {
                    if ($request->has('often')) $schedule->often = $request->often;
                    if ($request->has('start')) $schedule->start = $request->start;
                    if ($request->has('end')) $schedule->end = $request->end;
                }
                
                $schedule->save();
            // -------------------------

            return $user;
        });
        // -------------------------------------------

        // send response ----------------------
        if ($user) {
            // generate token
            $token = $user->createToken('auth_token')->plainTextToken;

            // data
            $data = User::with('level','icon','category','get_avatar_male','get_avatar_female','theme','language','schedule','subscription')
                ->find($user->id);

            // count user pool
            UserPool::dispatch($user)->onQueue(env('SUPERVISOR'));

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'data' => $data
            ], 201); 
        }
        // ---------------------------------
    }
}