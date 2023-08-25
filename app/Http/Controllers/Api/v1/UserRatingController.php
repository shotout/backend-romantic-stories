<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRatingController extends Controller
{
    public function show()
    {
        $isRating = Rating::where('user_id', auth('sanctum')->user()->id)->exists();
        return response()->json([
            'status' => 'success',
            'data' => $isRating
        ], 200);
    }

    public function store(Request $request)
    {
        $rating = Rating::firstOrCreate(
            ['user_id' =>  auth('sanctum')->user()->id],
            ['value' => $request->value ?? 0]
        );

        return response()->json([
            'status' => 'success',
            'data' => $rating
        ], 201);
    }
}