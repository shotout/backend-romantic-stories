<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaselyController extends Controller
{
    public function index(request $request)
    {
        $data = $request->all();
        Log::info($data);
        $user = User::where('purchasely_id', $data['anonymous_user_id'])->first();

        if ($user) {
            $user->is_member = 1;
            $user->save();

            $subscription = Subscription::where('user_id', $user->id)->first();

            if ($data['event_name'] == 'ACTIVATE') {
                if ($data['store_product_id'] == 'mooti_annual_package') {
                    $type = 2;
                } else {
                    $type = 3;
                }

                // update the subscription end
                $subscription->type = $type;
                $subscription->started = date('Y-m-d', strtotime($data['purchased_at']));
                $subscription->renewal = date('Y-m-d', strtotime($data['next_renewal_at']));
                $subscription->purchasely_data = $data;
                $subscription->save();
            }

            if ($data['event_name'] == 'DEACTIVATE') {
                // update the subscription status
                $subscription->type = 1;
                $subscription->started = null;
                $subscription->renewal = null;
                $subscription->subscription_data = null;
                $subscription->purchasely_data = $data;
                $subscription->save();
            }
        }

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
