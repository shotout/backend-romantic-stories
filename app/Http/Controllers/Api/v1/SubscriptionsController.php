<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::where('user_id', auth()->user()->id)->get();
        return response()->json($subscriptions);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'subscription_type' => 'required',
        ]);

        if ($request->subscription_type == 1) {

            $subscriptions = Subscription::where('user_id', auth()->user()->id)->first();
            if ($subscriptions) {
                $subscriptions->type = $request->subscription_type;
                $subscriptions->plan_id = 1;
                $subscriptions->started = null;
                $subscriptions->renewal = null;
                $subscriptions->subscription_data = null;
                $subscriptions->save();
            } 
            return response()->json([
                'status' => 'ok',
                'data' => $subscriptions
            ], 200);
        }

        if ($request->subscription_type == 2) {

            $user = User::where('id', auth()->user()->id)->first();
            $user->purchasely_id = $request->purchasely_id;
            $user->save();

            $subscriptions = Subscription::where('user_id', auth()->user()->id)->first();
            if ($subscriptions) {
                $subscriptions->type = $request->subscription_type;
                $subscriptions->plan_id = 2;
                $subscriptions->started = Carbon::now();
                $subscriptions->renewal = Carbon::now()->addDay(2);
                $subscriptions->subscription_data = $request->subscription_data;
                $subscriptions->save();
            } 
            return response()->json([
                'status' => 'ok',
                'data' => $subscriptions
            ], 200);
        }

        if ($request->subscription_type == 3) {

            $user = User::where('id', auth()->user()->id)->first();
            $user->purchasely_id = $request->purchasely_id;
            $user->save();

            $subscriptions = Subscription::where('user_id', auth()->user()->id)->first();
            if ($subscriptions) {
                $subscriptions->type = $request->subscription_type;
                $subscriptions->plan_id = 3;
                $subscriptions->started = Carbon::now();
                $subscriptions->renewal = Carbon::now()->addMonth(1);
                $subscriptions->subscription_data = $request->subscription_data;
                $subscriptions->save();
            } 
            return response()->json([
                'status' => 'ok',
                'data' => $subscriptions
            ], 200);
        }

        if ($request->subscription_type == 4) {

            $user = User::where('id', auth()->user()->id)->first();
            $user->purchasely_id = $request->purchasely_id;
            $user->save();

            $subscriptions = Subscription::where('user_id', auth()->user()->id)->first();
            if ($subscriptions) {
                $subscriptions->type = $request->subscription_type;
                $subscriptions->plan_id = 4;
                $subscriptions->save();
            } 
            return response()->json([
                'status' => 'ok',
                'data' => $subscriptions
            ], 200);
        }

        if ($request->subscription_type == 5) {
            $user = User::where('id', auth()->user()->id)->first();
            $user->purchasely_id = $request->purchasely_id;
            $user->save();

            $subscriptions = Subscription::where('user_id', auth()->user()->id)->first();
            if ($subscriptions) {
                $subscriptions->type = $request->subscription_type;
                $subscriptions->plan_id = 5;
                $subscriptions->save();
            } 
            return response()->json([
                'status' => 'ok',
                'data' => $subscriptions
            ], 200);
        }
    }
}
