<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AvatarController extends Controller
{
    public function show(Request $request)
    {
        if (auth()->user()->type === 'anime') {
            if ($request->has('flag') && $request->flag != '') {
                if ($request->flag == 'book') {
                    if (auth()->user()->gender) {
                        if (strtolower(auth()->user()->gender) == "male") {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/anime/book/".auth()->user()->avatar_male.".png",
                                "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/positive.png"
                            );
                        } else {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/anime/book/".auth()->user()->avatar_female.".png",
                                "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_male."/positive.png"
                            );
                        }
                        
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/anime/book/".auth()->user()->avatar_male.".png",
                            "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/positive.png"
                        );
                    }
                } else if ($request->flag == 'notif') {
                    if (auth()->user()->gender) {
                        if (strtolower(auth()->user()->gender) == "male") {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/anime/".auth()->user()->avatar_male."/positive.png",
                                "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/positive.png",
                                // "banner" => "/assets/images/avatars/anime/banner/notif.png"
                            );
                        } else {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/positive.png",
                                "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_male."/positive.png",
                                // "banner" => "/assets/images/avatars/anime/banner/notif.png"
                            );
                        }
                        
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/anime/".auth()->user()->avatar_male."/positive.png",
                            "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/positive.png",
                            // "banner" => "/assets/images/avatars/anime/banner/notif.png"
                        );
                    }
                } else if ($request->flag == 'random') {
                    $avatars = array('angry','confused','cry','dizzy','excited','friendly','inlove','positive','scare','think');
                    $user = User::findOrFail(auth()->user()->id);
                    $random = $avatars[$user->random_avatar] ?? $avatars[0];

                    if (auth()->user()->gender) {
                        if (strtolower(auth()->user()->gender) == "male") {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/anime/".auth()->user()->avatar_male."/".$random.".png",
                                "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/".$random.".png",
                                "banner" => "/assets/images/avatars/anime/banner/".auth()->user()->avatar_male.".png",
                                "heart" => "/assets/images/avatars/anime/banner/heart.png",
                            );
                        } else {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/".$random.".png",
                                "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_male."/".$random.".png",
                                "banner" => "/assets/images/avatars/anime/banner/".auth()->user()->avatar_male.".png",
                                "heart" => "/assets/images/avatars/anime/banner/heart.png",
                            );
                        }
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/anime/".auth()->user()->avatar_male."/".$random.".png",
                            "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/".$random.".png",
                            "banner" => "/assets/images/avatars/anime/banner/".auth()->user()->avatar_male.".png",
                            "heart" => "/assets/images/avatars/anime/banner/heart.png",
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
                                "me" => "/assets/images/avatars/anime/".auth()->user()->avatar_male."/".$request->flag.".png",
                                "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/".$request->flag.".png",
                                "banner" => "/assets/images/avatars/anime/banner/".auth()->user()->avatar_male.".png",
                                "heart" => "/assets/images/avatars/anime/banner/heart.png",
                            );
                        } else {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/".$request->flag.".png",
                                "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_male."/".$request->flag.".png",
                                "banner" => "/assets/images/avatars/anime/banner/".auth()->user()->avatar_male.".png",
                                "heart" => "/assets/images/avatars/anime/banner/heart.png",
                            );
                        }
                        
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/anime/".auth()->user()->avatar_male."/".$request->flag.".png",
                            "partner" => "/assets/images/avatars/anime/".auth()->user()->avatar_female."/".$request->flag.".png",
                            "banner" => "/assets/images/avatars/anime/banner/".auth()->user()->avatar_male.".png",
                            "heart" => "/assets/images/avatars/anime/banner/heart.png",
                        );
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'data' => $data
                ], 200); 
            }
        }

        if (auth()->user()->type === 'realistic') {
            if ($request->has('flag') && $request->flag != '') {
                if ($request->flag == 'book') {
                    if (auth()->user()->gender) {
                        if (strtolower(auth()->user()->gender) == "male") {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/realistic/book/".auth()->user()->avatar_male.".png",
                                "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/casual.png"
                            );
                        } else {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/realistic/book/".auth()->user()->avatar_female.".png",
                                "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_male."/casual.png"
                            );
                        }
                        
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/realistic/book/".auth()->user()->avatar_male.".png",
                            "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/casual.png"
                        );
                    }
                } else if ($request->flag == 'notif') {
                    if (auth()->user()->gender) {
                        if (strtolower(auth()->user()->gender) == "male") {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/realistic/".auth()->user()->avatar_male."/casual.png",
                                "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/casual.png",
                                // "banner" => "/assets/images/avatars/realistic/banner/notif.png"
                            );
                        } else {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/casual.png",
                                "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_male."/casual.png",
                                // "banner" => "/assets/images/avatars/realistic/banner/notif.png"
                            );
                        }
                        
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/realistic/".auth()->user()->avatar_male."/casual.png",
                            "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/casual.png",
                            // "banner" => "/assets/images/avatars/realistic/banner/notif.png"
                        );
                    }
                } else if ($request->flag == 'random') {
                    $avatars = array('beach','casual','cocktail','professional','sport','winter','travelling','relaxed','autumn','street');
                    $user = User::findOrFail(auth()->user()->id);
                    $random = $avatars[$user->random_avatar] ?? $avatars[0];
                    $banner = "/assets/images/avatars/realistic/banner/".auth()->user()->avatar_male.".png";
                    if ($random == 'beach') $banner = "/assets/images/avatars/realistic/banner/beach.png";

                    if (auth()->user()->gender) {
                        if (strtolower(auth()->user()->gender) == "male") {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/realistic/".auth()->user()->avatar_male."/".$random.".png",
                                "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/".$random.".png",
                                "banner" => $banner,
                                "heart" => "/assets/images/avatars/realistic/banner/heart.png",
                            );
                        } else {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/".$random.".png",
                                "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_male."/".$random.".png",
                                "banner" => $banner,
                                "heart" => "/assets/images/avatars/realistic/banner/heart.png",
                            );
                        }
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/realistic/".auth()->user()->avatar_male."/".$random.".png",
                            "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/".$random.".png",
                            "banner" => $banner,
                            "heart" => "/assets/images/avatars/realistic/banner/heart.png",
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
                    $banner = "/assets/images/avatars/realistic/banner/".auth()->user()->avatar_male.".png";
                    if ($request->flag == 'beach') $banner = "/assets/images/avatars/realistic/banner/beach.png";

                    if (auth()->user()->gender) {
                        if (strtolower(auth()->user()->gender) == "male") {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/realistic/".auth()->user()->avatar_male."/".$request->flag.".png",
                                "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/".$request->flag.".png",
                                "banner" => $banner,
                                "heart" => "/assets/images/avatars/realistic/banner/heart.png",
                            );
                        } else {
                            $data = (object) array(
                                "me" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/".$request->flag.".png",
                                "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_male."/".$request->flag.".png",
                                "banner" => $banner,
                                "heart" => "/assets/images/avatars/realistic/banner/heart.png",
                            );
                        }
                        
                    } else {
                        $data = (object) array(
                            "me" => "/assets/images/avatars/realistic/".auth()->user()->avatar_male."/".$request->flag.".png",
                            "partner" => "/assets/images/avatars/realistic/".auth()->user()->avatar_female."/".$request->flag.".png",
                            "banner" => $banner,
                            "heart" => "/assets/images/avatars/realistic/banner/heart.png",
                        );
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'data' => $data
                ], 200); 
            }
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'bad request'
        ], 400); 
    }
}