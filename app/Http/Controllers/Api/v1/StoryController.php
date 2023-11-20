<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Models\Story;
use App\Models\Category;
use App\Models\PastStory;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserAudio;

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
            $column = 'id';
        }

        // order direction
        if ($request->has('dir') && $request->input('dir') != '') {
            $dir = $request->input('dir');
        } else {
            $dir = 'asc';
        }

        // past stories
        $pastStories = PastStory::where('user_id', auth('sanctum')->user()->id)
            ->pluck('story_id')
            ->toArray();

        // query
        $query = Story::with('is_collection','category','audio','audio_enable')
            ->whereNotIn('id', $pastStories)
            ->where('status', 2)
            ->orderBy($column, $dir);

        // rules
        $user = User::with('subscription','my_story')->findOrFail(auth()->user()->id);
        if ($user->subscription->type === 1) {
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
        } else {
            // pagination 
            $data = $query->paginate($length);

            foreach ($user->my_story->rules as $index => $item) {
                $str = Story::where('category_id', $item)->first();
                if ($str) $data[$index] = $str;
            }
        }

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

        // sugest other story for member user
        $other = [];
        if (!$isFreeUser) {
            $other = Story::with('is_collection','category')
                ->whereNotIn('id', $pastStories)
                ->where('status', 2)
                ->orderBy("count_past", "desc")
                ->take(3)
                ->get();
        }

        // retun response
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'other' => $other,
            'flag' => (object) array(
                'month_free' => $month_free
            )
        ], 200);
    }

    public function show($id)
    {
        $story = Story::with('is_collection','category','audio','audio_enable')->find($id);
        if (!$story) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $story
        ], 200);
    }

    public function share($id)
    {
        $story = Story::find($id);

        if (!$story) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data not found'
            ], 404);
        }

        $story->count_share++;
        $story->update();

        return response()->json([
            'status' => 'success',
            'data' => null
        ], 200);
    }

    public function all(Request $request)
    {
        // past stories
        $pastStories = PastStory::where('user_id', auth('sanctum')->user()->id)
            ->pluck('story_id')
            ->toArray();

        // limit
        if ($request->has('length') && $request->input('length') != '') {
            $length = $request->input('length');
        } else {
            $length = 10;
        }

        // categories
        $category = Category::with('image')->where('status', 2)->get();

        // most read
        $query1 = Story::with('is_collection','category')
            ->whereNotIn('id', $pastStories)
            ->where('status', 2)
            ->orderBy("count_past", "desc");

        // most share
        $query2 = Story::with('is_collection','category')
            ->whereNotIn('id', $pastStories)
            ->where('status', 2)
            ->orderBy("count_share", "desc");

        // search
        if ($request->has('search') && $request->search != '') {
            $query1->where('title_en', 'like', '%' . $request->search . '%');
            $query2->where('title_en', 'like', '%' . $request->search . '%');
        }

        $most_read = $query1->take($length)->get();
        $most_share = $query2->take($length)->get();

        // retun response
        return response()->json([
            'status' => 'success',
            'most_read' => $most_read,
            'category' => $category,
            'most_share' => $most_share
        ], 200);
    }

    // public function most(Request $request)
    // {
    //     // limit
    //     if ($request->has('length') && $request->input('length') != '') {
    //         $length = $request->input('length');
    //     } else {
    //         $length = 10;
    //     }

    //     // order by field
    //     if ($request->has('column') && $request->input('column') != '') {
    //         $column = $request->input('column');
    //     } else {
    //         $column = 'count_past';
    //     }

    //     // order direction
    //     if ($request->has('dir') && $request->input('dir') != '') {
    //         $dir = $request->input('dir');
    //     } else {
    //         $dir = 'desc';
    //     }

    //     // query
    //     $query = Story::with('is_collection','category')
    //         ->where('status', 2)
    //         ->orderBy($column, $dir);
                    
    //     // pagination
    //     $data = $query->paginate($length);

    //     // retun response
    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $data
    //     ], 200);
    // }
}