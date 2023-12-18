<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Models\Story;
use App\Models\Category;
use App\Models\PastStory;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StoryRating;
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

        // sugest other story for member user
        $user = User::with('subscription','my_story')->findOrFail(auth()->user()->id);
        $other = [];
        if ($user->subscription->plan_id != 1) {
            $other = Story::with('is_collection','category')
                ->whereNotIn('id', $pastStories)
                ->where('status', 2)
                ->orderBy("count_past", "desc")
                ->take(3)
                ->get();
        }

        // priority story
        $query = Story::with('is_rating','is_collection','category','audio','audio_enable')
            ->whereNotIn('id', $pastStories)
            ->where('is_priority', 1)
            ->where('status', 2)
            ->orderBy($column, $dir);

        $data = $query->first();

        // if priority story null
        if (!$data) {
            // query
            $query = Story::with('is_rating','is_collection','category','audio','audio_enable')
                ->whereNotIn('id', $pastStories)
                ->where('status', 2)
                ->orderBy($column, $dir);

            // rules
            if ($user->my_story->actual < count($user->my_story->rules)) {
                $query->where('category_id', $user->my_story->rules[$user->my_story->actual]);
                $user->my_story->actual++;
                $user->my_story->update();
            } else {
                $query->where('category_id', $user->my_story->rules[0]);
                $user->my_story->actual = 1;
                $user->my_story->update();
            }
            // if ($user->subscription->type === 1) {
            //     if ($user->my_story->actual < count($user->my_story->rules)) {
            //         $query->where('category_id', $user->my_story->rules[$user->my_story->actual]);
            //         $user->my_story->actual++;
            //         $user->my_story->update();
            //     } else {
            //         $query->where('category_id', $user->my_story->rules[0]);
            //         $user->my_story->actual = 1;
            //         $user->my_story->update();
            //     }
            //     // pagination
            //     $data = $query->paginate(1);
            // } else {
            //     // pagination 
            //     $data = $query->paginate($length);

            //     foreach ($user->my_story->rules as $index => $item) {
            //         $str = Story::where('category_id', $item)->first();
            //         if ($str) $data[$index] = $str;
            //     }
            // }

            $data = $query->first();
        }

        // parsing story from backend
        $data->content_en = mb_str_split($data->content_en, 950);

        // retun response
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'other' => $other
        ], 200);
    }

    public function show($id)
    {
        $story = Story::with('is_rating','is_collection','category','audio','audio_enable')->find($id);
        if (!$story) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data not found'
            ], 404);
        }

        $story->content_en = mb_str_split($story->content_en, 950);

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
            $dir = 'desc';
        }

        // categories
        $category = Category::with('image','cover')->whereNot('id', 4)->where('status', 2)->get();

        // most read
        $query1 = Story::with('is_collection','category')
            ->whereNotIn('id', $pastStories)
            ->where('status', 2)
            ->orderBy("count_past", "desc")
            ->orderBy($column, $dir);

        // most share
        $query2 = Story::with('is_collection','category')
            ->whereNotIn('id', $pastStories)
            ->where('status', 2)
            ->orderBy("count_share", "desc")
            ->orderBy($column, $dir);

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

    public function category(Request $request, $id)
    {
        // category
        $category = Category::select('id','name')->find($id);
        if (!$category) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data not found'
            ], 404);
        }

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

        // order by field
        if ($request->has('column') && $request->input('column') != '') {
            $column = $request->input('column');
        } else {
            $column = 'title_en';
        }

        // order direction
        if ($request->has('dir') && $request->input('dir') != '') {
            $dir = $request->input('dir');
        } else {
            $dir = 'asc';
        }

        // story
        $query1 = Story::select('id','category_id','title_en','title_id')
            ->with('is_collection','category')
            ->whereNotIn('id', $pastStories)
            ->where('category_id', $category->id)
            ->where('status', 2)
            ->orderBy($column, $dir);

        // most share
        $query2 = Story::select('id','category_id','title_en','title_id')
            ->with('is_collection','category:id,name')
            ->whereNotIn('id', $pastStories)
            ->where('category_id', $category->id)
            ->where('status', 2)
            ->orderBy("count_share", "desc");

        // search
        if ($request->has('search') && $request->search != '') {
            $query1->where('title_en', 'like', '%' . $request->search . '%');
            $query2->where('title_en', 'like', '%' . $request->search . '%');
        }

        $stories = $query1->get();
        $most_share = $query2->take($length)->get();

        // retun response
        return response()->json([
            'status' => 'success',
            'category' => $category,
            'most_share' => $most_share,
            'data' => $stories,
        ], 200);
    }

    public function rating(Request $request, $id)
    {
        $story = Story::find($id);
        if (!$story) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data not found'
            ], 404);
        }

        $story_rating = StoryRating::where('story_id', $story->id)
            ->where('user_id', auth('sanctum')->user()->id)
            ->first();
        if (!$story_rating) $story_rating = new StoryRating;
        $story_rating->user_id = auth('sanctum')->user()->id;
        $story_rating->story_id = $story->id;
        $story_rating->value = $request->value ?? 0;
        $story_rating->save();

        return response()->json([
            'status' => 'success',
            'data' => $story_rating
        ], 201);
    }
}