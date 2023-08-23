<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Models\Story;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        // limit
        // if ($request->has('length') && $request->input('length') != '') {
        //     $length = $request->input('length');
        // } else {
        //     $length = 1;
        // }

        // order by field
        if ($request->has('column') && $request->input('column') != '') {
            $column = $request->input('column');
        } else {
            $column = 'id';
        }

        // order direction
        if ($request->has('dir') && $request->input('dir') != '') {
            $dir = $request->input('dir');
        } else {
            $dir = 'asc';
        }

        // query
        $query = Story::where('status', 2)->orderBy($column, $dir);

        // rules
        $user = User::with('my_story')->findOrFail(auth()->user()->id);
        if ($user->my_story->actual < count($user->my_story->rules)) {
            $query->where('category_id', $user->my_story->rules[$user->my_story->actual]);
            $user->my_story->actual++;
            $user->my_story->update();
        } else {
            $query->where('category_id', $user->my_story->rules[0]);
            $user->my_story->actual = 1;
            $user->my_story->update();
        }
                    
        // pagination
        $data = $query->paginate(1);

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