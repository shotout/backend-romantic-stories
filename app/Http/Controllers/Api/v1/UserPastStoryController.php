<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Story;
use App\Models\PastStory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPastStoryController extends Controller
{
    public function index(Request $request)
    {
        if (auth('sanctum')->user()->subscription->type == 1) {
            $ps = PastStory::where('user_id', auth('sanctum')->user()->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->pluck('story_id')
                ->toArray();

            $stories = array();

            foreach ($ps as $item) {
                $story = Story::with('is_collection')->find($item);
                if ($story) $stories[] = $story;
            }

            return response()->json([
                'status' => 'success',
                'data' => $stories
            ], 200);
        } else {
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
                $column = 'created_at';
            }

            // order direction
            if ($request->has('dir') && $request->input('dir') != '') {
                $dir = $request->input('dir');
            } else {
                $dir = 'desc';
            }

            $query = PastStory::where('user_id', auth('sanctum')->user()->id)
                ->orderBy($column, $dir);

            // pagination
            if ($request->has('all')) {
                $stories = $query->get();
            } else {
                $stories = $query->paginate($length);
            }
            
            foreach ($stories as $i => $item) {
                $story = Story::with('is_collection')->find($item->story_id);
                if ($story) $stories[$i] = $story;
            }

            return response()->json([
                'status' => 'success',
                'data' => $stories
            ], 200);
        }
    }

    public function store($id)
    {
        $story = Story::with('is_collection')->find($id);
        if (!$story) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data not found'
            ], 404);
        }
        $story->count_past++;
        $story->update();

        $ps = PastStory::where('user_id', auth('sanctum')->user()->id)
            ->where('story_id', $id)
            ->first();

        if (!$ps) {
            $ps = new PastStory;
            $ps->user_id = auth('sanctum')->user()->id;
            $ps->story_id = $id;
            $ps->save();
        }

        if ($story->is_collection?->is_read_later == 1) {
            $story->is_collection->delete();
        }

        return response()->json([
            'status' => 'success',
            'data' => $ps
        ], 200);
    }

    public function destroy($id)
    {
        $ps = PastStory::where('user_id', auth('sanctum')->user()->id)
            ->where('story_id', $id)
            ->first();

        if (!$ps) {
            return response()->json([
                'status' => 'failed',
                'message' => 'data not found'
            ], 404);
        }
    
        $ps->delete();
    
        return response()->json([
            'status' => 'success',
            'data' => $ps
        ], 200);
    }
}