<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Story;
use App\Models\PastStory;
use App\Models\UserTrack;
use Illuminate\Bus\Queueable;
use App\Models\CollectionStory;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Auth\Credentials\ServiceAccountCredentials;

class StoryNotif implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $story = Story::where('has_notif', false)->orderBy('id', 'asc')->first();

        if ($story) {  
            User::with('schedule','track')->whereHas('schedule')->where('notif_enable',1)->whereNotNull('fcm_token')
                ->chunkById(500, function (Collection $users) use ($story) {
                foreach ($users as $user) {
                    if ($user->schedule->counter_notif < 1) {
                        if ($user->schedule->timezone && now()->setTimezone($user->schedule->timezone)->format('H:i:s') >= '18:00:00' && now()->setTimezone($user->schedule->timezone)->format('H:i:s') <= '18:10:00') {

                            // $is_past = PastStory::where('user_id', $user->id)->where('story_id', $story->id)->exists();
                            // $is_coll = CollectionStory::where('user_id', $user->id)->where('story_id', $story->id)->exists();

                            $scope = "https://www.googleapis.com/auth/firebase.messaging";
                            $config = env("FIREBASE_FILE");
                            $creadentials = new ServiceAccountCredentials($scope, $config);
                            $token = $creadentials->fetchAuthToken(HttpHandlerFactory::build());
                            $access_token = $token['access_token'];
                            $counter = $user->notif_count + 1;

                            $has_read = UserTrack::where('user_id', $user->id)
                                ->whereDate('last_get_story', now()->setTimezone($user->schedule->timezone))
                                ->exists();

                            if ($has_read) {
                                $data = [
                                    "message" => [
                                        "token" => $user->fcm_token,
                                        "notification" => [
                                            "title" => "Have you already read today's story?❤️🌶️",
                                            "body" => "Read the story of the day and experience the magic.",
                                        ],
                                        "data" => [
                                            "id" => "$story->id",
                                            "type" => "story",
                                            "icon" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                            "sound" => "circle.mp3",
                                            "badge" => "$counter"
                                        ],
                                        "apns" => (object) [
                                            "payload" => (object) [
                                                "aps" => (object) [
                                                    "sound" => "circle.mp3",
                                                    "badge" => "$counter"
                                                ]
                                            ]
                                        ],
                                    ]
                                ];
                                // $data = [
                                //     "to" => $user->fcm_token,
                                //     "type" => "story",
                                //     "data" => [
                                //         "id" => $story->id,
                                //     ],
                                //     "notification" => [
                                //         "title" => "Have you already read today's story?❤️🌶️",
                                //         "body" => "Read the story of the day and experience the magic.",
                                //         "icon" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                //         "sound" => "circle.mp3",
                                //         "badge" => $user->notif_count + 1
                                //     ]
                                // ];
                            } else {
                                $data = [
                                    "message" => [
                                        "token" => $user->fcm_token,
                                        "notification" => [
                                            "title" => "New story alert! 💥🔓",
                                            "body" => "Dive into our latest tale of passion and intrigue. Tap to read now!",
                                        ],
                                        "data" => [
                                            "id" => "$story->id",
                                            "type" => "story",
                                            "icon" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                            "sound" => "circle.mp3",
                                            "badge" => "$counter"
                                        ],
                                        "apns" => (object) [
                                            "payload" => (object) [
                                                "aps" => (object) [
                                                    "sound" => "circle.mp3",
                                                    "badge" => "$counter"
                                                ]
                                            ]
                                        ],
                                    ]
                                ];
                                // $data = [
                                //     "to" => $user->fcm_token,
                                //     "type" => "story",
                                //     "data" => [
                                //         "id" => $story->id,
                                //     ],
                                //     "notification" => [
                                //         "title" => "New story alert! 💥🔓",
                                //         "body" => "Dive into our latest tale of passion and intrigue. Tap to read now!",
                                //         "icon" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                //         "sound" => "circle.mp3",
                                //         "badge" => $user->notif_count + 1
                                //     ]
                                // ];
                            }
                            
                            $dataString = json_encode($data);
                                    
                            $headers = [
                                'Authorization: Bearer ' . $access_token,
                                'Content-Type: application/json',
                            ];
                                    
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/'.env('FIREBASE_PROJECT_ID').'/messages:send');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                                            
                            $response = curl_exec($ch);
                            Log::info($response);

                            // update user schedule
                            $user->schedule->counter_notif++;
                            $user->schedule->update();

                            // update user
                            $user->notif_count++;
                            $user->update();
                        }
                    } else {
                        // reset schedule counter
                        if ($user->schedule->timezone && now()->setTimezone($user->schedule->timezone)->format('H:i:s') >= '18:20:00' && now()->setTimezone($user->schedule->timezone)->format('H:i:s') <= '18:30:00') {
                            $user->schedule->counter_notif = 0;
                            $user->schedule->update();
                        }
                    }
                }
            });

            // update status
            $story->has_notif = true;
            $story->update();
        } else {
            // reset has notif
            Story::where('has_notif', true)->update(['has_notif' => false]);
        }

        Log::info('Job StoryNotif Success ...');
    }
}
