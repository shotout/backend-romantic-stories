<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Models\Story;
use App\Models\Category;
use App\Models\PastStory;
use App\Models\UserTrack;
use App\Models\StoryRating;
use Illuminate\Http\Request;
use App\Models\CollectionStory;
use App\Http\Controllers\Controller;

class OfflineStoryController extends Controller
{
    public function category(Request $request, $id)
    {
        // category
        $category = Category::select('id', 'name')->find($id);
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

        // my collections
        $myCollections = CollectionStory::where('user_id', auth('sanctum')->user()->id)
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
        $query1 = Story::select('id', 'category_id', 'title_en', 'title_id', 'content_en', 'content_id')
            ->with([
                'is_collection',
                'category.cover' => fn($q) => $q->where('model',auth()->user()->type),
                'category.cover_audio' => fn($q) => $q->where('model',auth()->user()->type),
                'audio',
            ])
            ->whereNotIn('id', $pastStories)
            ->whereNotIn('id', $myCollections)
            ->where('category_id', $category->id)
            ->where('status', 2)
            ->orderBy($column, $dir);

        // most share
        $query2 = Story::select('id', 'category_id', 'title_en', 'title_id', 'content_en', 'content_id')
            ->with([
                'is_collection',
                'category.cover' => fn($q) => $q->where('model',auth()->user()->type),
                'category.cover_audio' => fn($q) => $q->where('model',auth()->user()->type),
                'audio',
            ])
            ->whereNotIn('id', $pastStories)
            ->whereNotIn('id', $myCollections)
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

    public function all(Request $request)
    {
        // past stories
        // $pastStories = PastStory::where('user_id', auth('sanctum')->user()->id)
        //     ->pluck('story_id')
        //     ->toArray();

        // my collections
        // $myCollections = CollectionStory::where('user_id', auth('sanctum')->user()->id)
        //     ->pluck('story_id')
        //     ->toArray();

        // limit
        // if ($request->has('length') && $request->input('length') != '') {
        //     $length = $request->input('length');
        // } else {
        //     $length = 10;
        // }

        // order by field
        // if ($request->has('column') && $request->input('column') != '') {
        //     $column = $request->input('column');
        // } else {
        //     $column = 'id';
        // }

        // order direction
        // if ($request->has('dir') && $request->input('dir') != '') {
        //     $dir = $request->input('dir');
        // } else {
        //     $dir = 'desc';
        // }

        // categories
        $category = Category::with([
                'image' => fn($q) => $q->where('model',auth()->user()->type),
                'cover' => fn($q) => $q->where('model',auth()->user()->type),

                'stories.is_rating',
                'stories.is_collection',
                'stories.category.cover' => fn($q) => $q->where('model',auth()->user()->type),
                'stories.category.cover_audio' => fn($q) => $q->where('model',auth()->user()->type),
                'stories.audio',
                'stories.audio_enable'
            ])
            ->whereNot('id', 4)
            ->where('status', 2)
            ->get();

        // most read
        // $query1 = Story::with([
        //         'is_collection',
        //         'category.cover' => fn($q) => $q->where('model',auth()->user()->type),
        //         'category.cover_audio' => fn($q) => $q->where('model',auth()->user()->type),
        //         'audio',
        //     ])
        //     ->whereNotIn('id', $pastStories)
        //     ->whereNotIn('id', $myCollections)
        //     ->where('status', 2)
        //     ->orderBy("count_past", "desc")
        //     ->orderBy($column, $dir);

        // most share
        // $query2 = Story::with([
        //         'is_collection',
        //         'category.cover' => fn($q) => $q->where('model',auth()->user()->type),
        //         'category.cover_audio' => fn($q) => $q->where('model',auth()->user()->type),
        //         'audio',
        //     ])
        //     ->whereNotIn('id', $pastStories)
        //     ->whereNotIn('id', $myCollections)
        //     ->where('status', 2)
        //     ->orderBy("count_share", "desc")
        //     ->orderBy($column, $dir);

        // search
        // if ($request->has('search') && $request->search != '') {
        //     $query1->where('title_en', 'like', '%' . $request->search . '%');
        //     $query2->where('title_en', 'like', '%' . $request->search . '%');
        // }

        // $most_read = $query1->take($length)->get();
        // $most_share = $query2->take($length)->get();

        // retun response
        return response()->json([
            'status' => 'success',
            // 'most_read' => $most_read,
            'data' => $category,
            // 'most_share' => $most_share
        ], 200);
    }
}
