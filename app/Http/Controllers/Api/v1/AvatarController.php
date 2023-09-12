<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
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
            } else if ($request->flag == 'notif') {
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
                            "partner" => "/assets/images/avatars/".auth()->user()->avatar_male."/positive.png",
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
            } else if ($request->flag == 'random') {
                $avatars = array('angry','confused','cry','dizzy','excited','friendly','inlove','positive','scare','think');
                $user = User::findOrFail(auth()->user()->id);
                $random = $avatars[$user->random_avatar];

                if (auth()->user()->gender) {
                    if (strtolower(auth()->user()->gender) == "male") {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/".auth()->user()->avatar_male."/".$random.".png",
                            "partner" => "/assets/images/avatars/".auth()->user()->avatar_female."/".$random.".png",
                            "banner" => "/assets/images/avatars/banner/".auth()->user()->avatar_male.".png",
                            "heart" => "/assets/images/avatars/banner/heart.png",
                        );
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/".auth()->user()->avatar_female."/".$random.".png",
                            "partner" => "/assets/images/avatars/".auth()->user()->avatar_male."/".$random.".png",
                            "banner" => "/assets/images/avatars/banner/".auth()->user()->avatar_male.".png",
                            "heart" => "/assets/images/avatars/banner/heart.png",
                        );
                    }
                } else {
                    $data = (object) array(
                        "me" => "/assets/images/avatars/1/".$random.".png",
                        "partner" => "/assets/images/avatars/4/".$random.".png",
                        "banner" => "/assets/images/avatars/banner/1.png",
                        "heart" => "/assets/images/avatars/banner/heart.png",
                    );
                }

                if ($user->random_avatar < 9) {
                    $user->random_avatar++;
                    $user->update();
                } else {
                    $user->random_avatar = 0;
                    $user->update();
                }
            } else {
                if (auth()->user()->gender) {
                    if (strtolower(auth()->user()->gender) == "male") {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/".auth()->user()->avatar_male."/".$request->flag.".png",
                            "partner" => "/assets/images/avatars/".auth()->user()->avatar_female."/".$request->flag.".png",
                            "banner" => "/assets/images/avatars/banner/".auth()->user()->avatar_male.".png",
                            "heart" => "/assets/images/avatars/banner/heart.png",
                        );
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/".auth()->user()->avatar_female."/".$request->flag.".png",
                            "partner" => "/assets/images/avatars/".auth()->user()->avatar_male."/".$request->flag.".png",
                            "banner" => "/assets/images/avatars/banner/".auth()->user()->avatar_male.".png",
                            "heart" => "/assets/images/avatars/banner/heart.png",
                        );
                    }
                    
                } else {
                    $data = (object) array(
                        "me" => "/assets/images/avatars/1/".$request->flag.".png",
                        "partner" => "/assets/images/avatars/4/".$request->flag.".png",
                        "banner" => "/assets/images/avatars/banner/1.png",
                        "heart" => "/assets/images/avatars/banner/heart.png",
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