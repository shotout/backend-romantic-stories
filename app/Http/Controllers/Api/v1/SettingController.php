<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function paywall()
    {
        $paywall = DB::table('preferences')->where('category', 'app_setting')
            ->where('field', 'force_show_paywall')
            ->where('status', 2)
            ->first();

        return response()->json([
            'status' => 'success',
            'data' => $paywall
        ], 200);
    }
}