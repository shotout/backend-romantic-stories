<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Icon;
use App\Models\Link;
use App\Models\Theme;
use App\Models\Avatar;
use App\Models\Version;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function categories()
    {
        $data = Category::with('image')->where('status', 2)->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function avatars(Request $request)
    {
        $query = Avatar::with('image')->where('status', 2);
        if ($request->has('gender') && $request->gender != '') $query->where('gender', $request->gender);
        $data = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function themes()
    {
        $data = Theme::where('status', 2)->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function languages()
    {
        $data = Language::with('image')->where('status', 2)->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function icons()
    {
        $data = Icon::with('image')->where('status', 2)->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function links(Request $request)
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

        $query = Link::with('icon')->where('status', 2)->orderBy($column, $dir);

        if ($request->has('flag') && $request->flag != '') {
            $query->where('flag', $request->flag);
        }

        if ($request->has('search') && $request->input('search') != '') {
            $query->where(function($q) use($request) {
                $q->where('title', 'like', '%' . $request->input('search') . '%');
            });
        }

        $data = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function versions()
    {
        $data = Version::get();
        
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);

    }
}