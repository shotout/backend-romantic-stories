<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AvatarController extends Controller
{
    public function show(Request $request)
    {
        if ($request->has('flag') && $request->flag != '') {
            if ($request->flag == 'book') {
                if (auth()->user()->gender) {
                    if (strtolower(auth()->user()->gender) == "male") {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/book/".auth()->user()->avatar_male.".png",
                            "partner" => "/assets/images/avatars/".auth()->user()->avatar_female."/positive.png"
                        );
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/book/".auth()->user()->avatar_female.".png",
                            "partner" => "/assets/images/avatars/".auth()->user()->avatar_male."/positive.png"
                        );
                    }
                    
                } else {
                    $data = (object) array(
                        "me" => "/assets/images/avatars/book/1.png",
                        "partner" => "/assets/images/avatars/4/positive.png"
                    );
                }
            }

            if ($request->flag == 'notif') {
                if (auth()->user()->gender) {
                    if (strtolower(auth()->user()->gender) == "male") {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/".auth()->user()->avatar_male."/positive.png",
                            "partner" => "/assets/images/avatars/".auth()->user()->avatar_female."/positive.png",
                            // "banner" => "/assets/images/avatars/banner/notif.png"
                        );
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/".auth()->user()->avatar_female."/positive.png",
                            "partner" => "/assets/images/avatars/banner/".auth()->user()->avatar_male."/positive.png",
                            // "banner" => "/assets/images/avatars/banner/notif.png"
                        );
                    }
                    
                } else {
                    $data = (object) array(
                        "me" => "/assets/images/avatars/1/positive.png",
                        "partner" => "/assets/images/avatars/4/positive.png",
                        // "banner" => "/assets/images/avatars/banner/notif.png"
                    );
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200); 
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'bad request'
        ], 400); 
    }
}