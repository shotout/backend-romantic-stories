<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Story;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        // limit
        if ($request->has('length') && $request->input('length') != '') {
            $length = $request->input('length');
        } else {
            $length = 10;
        }

        // order by field
        if ($request->has('column') && $request->input('column') != '') {
            $column = $request->input('column');
        } else {
            $column = 'sequence';
        }

        // order direction
        if ($request->has('dir') && $request->input('dir') != '') {
            $dir = $request->input('dir');
        } else {
            $dir = 'asc';
        }

        // query
        $query = Story::where('status', 2)->orderBy($column, $dir);
                    
        // pagination
        $data = $query->paginate($length);

        // free 1 month
        $isFreeUser = Subscription::where('user_id', auth('sanctum')->user()->id)
            ->where('type', 1)
            ->where('status', 2)
            ->exists();
        $hasMonthFree = Subscription::where('user_id', auth('sanctum')->user()->id)
            ->where('type', 5)
            ->exists();
        if ($isFreeUser && $hasMonthFree) {
            $month_free = true;
        } else {
            $month_free = false;
        }

        // retun response
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'flag' => (object) array(
                'month_free' => $month_free
            )
        ], 200);
    }
}