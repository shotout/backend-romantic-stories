<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Category;
use App\Models\Language;
use App\Models\Theme;

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
}