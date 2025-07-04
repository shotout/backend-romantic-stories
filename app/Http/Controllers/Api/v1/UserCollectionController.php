<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Story;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\CollectionStory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UserCollectionController extends Controller
{
    public function index(Request $request)
    {
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

        $query1 = Collection::where('user_id', auth('sanctum')->user()->id)
            ->withCount('stories')
            ->where('status', 2)
            ->orderBy($column, $dir);

        if ($column == 'name') {
            $stories = CollectionStory::where('user_id', auth()->user()->id)
                ->whereNull('collection_id')
                ->pluck('story_id')
                ->toArray();
            
            $query2 = Story::select('id', 'category_id', 'title_en', 'title_id')
                ->with([
                    'category.cover' => fn($q) => $q->where('model',auth()->user()->type),
                    'category.cover_audio' => fn($q) => $q->where('model',auth()->user()->type),
                ])
                ->whereIn('id', $stories)
                ->orderBy('title_en', $dir);

            // search
            if ($request->has('search') && $request->search != '') {
                $query2->where('title_en', 'like', '%' . $request->search . '%');
            }

            $query2 = $query2->get();
        } else {
            $stories = CollectionStory::with([
                'story.category.cover' => fn($q) => $q->where('model',auth()->user()->type),
                'story.category.cover_audio' => fn($q) => $q->where('model',auth()->user()->type),
                ])
                ->where('user_id', auth()->user()->id)
                ->whereNull('collection_id')
                ->orderBy($column, $dir);

            // search
            if ($request->has('search') && $request->search != '') {
                $stories->whereHas('story',function($q) use($request){
                    $q->where('title_en', 'like', '%' . $request->search . '%');
                });
            }
            
            $result = $stories->get();
            $query2 = array();

            foreach ($result as $item) {
                $query2[] = $item->story;
            }
        }

        // search
        if ($request->has('search') && $request->search != '') {
            $query1->where('name', 'like', '%' . $request->search . '%');
        }

        // pagination
        $collections = $query1->get();
        $outsides = $query2;

        // sugest story on serach null
        $alternative = [];
        if ($request->has('search') && $request->search != '') {
            if (!count($collections) && !count($outsides)) {
                $alternative = Story::with([
                        'is_collection',
                        'category.cover' => fn($q) => $q->where('model',auth()->user()->type),
                        'category.cover_audio' => fn($q) => $q->where('model',auth()->user()->type),
                    ])
                    ->where('status', 2)
                    ->orderBy("count_share", "desc")
                    ->take(5)
                    ->get();
            }
        }

        // expire
        foreach ($outsides as $item) {
            $cs = CollectionStory::where('user_id', auth()->user()->id)
                ->where('story_id', $item->id)
                ->first();
            $item->expire = $cs?->expire;
            $item->is_read_later = $cs?->is_read_later;
        }

        return response()->json([
            'status' => 'success',
            'data' => $collections,
            'outsides' => $outsides,
            'alternative' => $alternative
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $collection = Collection::withCount('stories')->find($id);
        if (!$collection) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Collection not found'
            ], 404);
        }

        // limit
        if ($request->has('length') && $request->input('length') != '') {
            $length = $request->input('length');
        } else {
            $length = 10;
        }

        // query
        $query = CollectionStory::with([
                'story.category.cover' => fn($q) => $q->where('model',auth()->user()->type),
                'story.category.cover_audio' => fn($q) => $q->where('model',auth()->user()->type),
            ])
            ->where('collection_id', $collection->id)
            ->orderBy('id', 'desc');

        // search
        if ($request->has('search') && $request->input('search') != '') {
            $query->whereHas('story', function($q) use($request) {
                $q->where('title_en', 'like', '%' . $request->input('search') . '%');
            });
        }

        // pagination
        $stories = $query->paginate($length);

        return response()->json([
            'status' => 'success',
            'data' => (object) array(
                'collection' => $collection,
                'stories' => $stories
            )
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $collection = Collection::where('name', $request->name)
            ->where('user_id', auth('sanctum')->user()->id)
            ->first();

        if ($collection) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Collection name has taken'
            ], 400);
        }

        $collection = new Collection;
        $collection->user_id = auth('sanctum')->user()->id;
        $collection->name = $request->name;
        $collection->save();

        return response()->json([
            'status' => 'success',
            'data' => $collection
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $hasCollection = Collection::where('name', $request->name)
            ->where('user_id', auth('sanctum')->user()->id)
            ->first();

        if ($hasCollection) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Collection name has taken'
            ], 400);
        }

        $collection = Collection::find($id);
        if (!$collection) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Collection not found'
            ], 404);
        }
        $collection->name = $request->name;
        $collection->update();

        return response()->json([
            'status' => 'success',
            'data' => $collection
        ], 200);
    }

    public function destroy($id)
    {
        $collection = Collection::where('id', $id)
            ->where('user_id', auth('sanctum')->user()->id)
            ->first();

        if (!$collection) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Collection not found'
            ], 404);
        }

        CollectionStory::where('collection_id', $collection->id)->update(['collection_id' => null]);
        $collection->delete();

        return response()->json([
            'status' => 'success',
            'data' => $collection
        ], 200);
    }

    public function storeStory($collection, $story)
    {
        $findCollection = Collection::find($collection);
        $findStory = Story::find($story);

        if (!$findCollection) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Collection not found'
            ], 404);
        }

        if (!$findStory) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Story not found'
            ], 404);
        }

        $cs = CollectionStory::where('story_id', $story)->where('user_id', auth()->user()->id)->first();
        if (!$cs) $cs = new CollectionStory;   
        $cs->user_id = auth()->user()->id;
        $cs->collection_id = $collection;
        $cs->story_id = $story;
        $cs->save();

        return response()->json([
            'status' => 'success',
            'data' => $cs
        ], 201);
    }

    public function destroyStory($collection, $story)
    {
        $findCollection = Collection::find($collection);
        $findStory = Story::find($story);

        if (!$findCollection) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Collection not found'
            ], 404);
        }

        if (!$findStory) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Story not found'
            ], 404);
        }

        $cs = CollectionStory::where('collection_id', $collection)
            ->where('story_id', $story)
            ->update(['collection_id' => null]);

        return response()->json([
            'status' => 'success',
            'data' => $cs
        ], 200);
    }

    public function storeStoryOutside(Request $request, $story)
    {
        $findStory = Story::find($story);
        if (!$findStory) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Story not found'
            ], 404);
        }

        $cs = CollectionStory::where('user_id', auth()->user()->id)
            ->where('story_id', $story)
            ->first();

        if (!$cs) {
            $cs = new CollectionStory;
            $cs->user_id = auth()->user()->id;
            $cs->story_id = $story;
            if ($request->flag == 'read_later') $cs->is_read_later = 1;
            $cs->save();
        }

        return response()->json([
            'status' => 'success',
            'data' => $cs
        ], 201);
    }

    public function destroyStoryOutside($story)
    {
        $findStory = Story::find($story);

        if (!$findStory) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Story not found'
            ], 404);
        }

        $cs = CollectionStory::where('user_id', auth()->user()->id)
            ->where('story_id', $story)
            ->first();

        if ($cs) $cs->delete();

        return response()->json([
            'status' => 'success',
            'data' => $cs
        ], 200);
    }
}