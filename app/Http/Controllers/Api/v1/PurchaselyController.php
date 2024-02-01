<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaselyController extends Controller
{
    public function index(request $request)
    {
        $data = $request->all();
        $user = User::with('subscription')->where('purchasely_id', $data['anonymous_user_id'])->first();

        if ($user && array_key_exists('next_renewal_at', $data)) {
            if ($data['event_name'] == 'ACTIVATE') {
                if ($data['plan'] === 'ErotalesUnlimitedStoriesandAudioAnnual' || $data['plan'] === 'erotales_unlimited_stories_audio_annual_50' || $data['plan'] === 'erotales_unlimited_stories_audio_annual_75' || $data['plan'] === 'upgrade_to_unlimited_stories_audio') {
                    $type = 3;
                } else if ($data['plan'] === 'Erotales_unlimitted_stories_annual' || $data['plan'] === 'Erotales_unlimitted_stories_annual_50' || $data['plan'] === 'Erotales_unlimitted_stories_annual_75') {
                    $type = 2;
                }

                $user->is_member = 1;
                $user->update();

                $user->subscription->plan_id = $type;
                $user->subscription->type = $type;
                $user->subscription->started = date('Y-m-d', strtotime($data['purchased_at']));
                $user->subscription->renewal = date('Y-m-d', strtotime($data['next_renewal_at']));
                $user->subscription->purchasely_data = $data;
                $user->subscription->update();
            }

            if ($data['event_name'] == 'DEACTIVATE') {
                $user->is_member = 0;
                $user->update();

                $user->subscription->plan_id = 1;
                $user->subscription->type = 1;
                $user->subscription->started = null;
                $user->subscription->renewal = null;
                $user->subscription->subscription_data = null;
                $user->subscription->purchasely_data = $data;
                $user->subscription->update();
            }
        }

        if ($user) {
            $user->subscription->subscription_data = $data;
            $user->subscription->update();
        }

        Log::info($data);

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
