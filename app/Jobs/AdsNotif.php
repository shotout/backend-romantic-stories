<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Message;
use App\Models\UserMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Auth\Credentials\ServiceAccountCredentials;

class AdsNotif implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::with('schedule')->where('notif_ads_enable',1)->where('is_member', 0)->whereNotNull('fcm_token')
            ->chunkById(500, function (Collection $users) {

            foreach ($users as $user) {
                if ($user->schedule) {
                    if ($user->schedule->timezone && now()->setTimezone($user->schedule->timezone)->format('H:i:s') >= '18:00:00' && now()->setTimezone($user->schedule->timezone)->format('H:i:s') <= '18:10:00') {
                        continue;
                    } else {
                        $time = now()->setTimezone($user->schedule->timezone);
                        $um = UserMessage::where('user_id', $user->id)
                            ->where('has_notif', false)
                            ->whereDate('time', $time)
                            ->whereTime('time', '<=', $time)
                            ->first();

                        if ($um) {
                            $message = Message::find($um->message_id);
                            if ($message) {
                                $scope = "https://www.googleapis.com/auth/firebase.messaging";
                                $config = env("FIREBASE_FILE");
                                $creadentials = new ServiceAccountCredentials($scope, $config);
                                $token = $creadentials->fetchAuthToken(HttpHandlerFactory::build());
                                $access_token = $token['access_token'];
                                $counter = $user->notif_count + 1;
                                
                                // $boxs = [
                                //     "name" => $user->name,
                                //     "selected_goal" => "selected_goal"
                                // ];

                                // foreach ($boxs as $key => $val) {
                                //     $descShort = str_replace('['.$key.']', $val, $message->push_text);
                                // }
                                // $descShort = str_replace('[name]', $user->name, $descShort);
                                $descShort = $message->push_text;

                                $placement = null;
                                if (in_array($message->id, array(1,2,3,4,5))) {
                                    $placement = "in_app";
                                } else {
                                    $placement = "offer_50";
                                }

                                // $data = [
                                //     "to" => $user->fcm_token,
                                //     "data" => (object) array(
                                //         "type" => "paywall",
                                //         "placement" => $placement,
                                //         "message_count" => $message->id
                                //     ),
                                //     "notification" => [
                                //         "title" => "EroTales App",
                                //         "body" => $descShort,   
                                //         "icon" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                //         "sound" => "circle.mp3",
                                //         "badge" => $user->notif_count + 1
                                //     ]
                                // ];
                                $data = [
                                    "message" => [
                                        "token" => $user->fcm_token,
                                        "notification" => [
                                            "title" => "EroTales App",
                                            "body" => $descShort,   
                                        ],
                                        "data" => (object) [
                                            "type" => "paywall",
                                            "placement" => $placement,
                                            "message_count" => "$message->id",
                                            "icon" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                            "sound" => "circle.mp3",
                                            "badge" => "$counter"
                                        ],
                                        "apns" => (object) [
                                            "payload" => (object) [
                                                "aps" => (object) [
                                                    "sound" => "circle.mp3",
                                                    "badge" => $counter
                                                ]
                                            ]
                                        ],
                                    ]
                                ];
                                
                                Log::info($data);
                    
                                $dataString = json_encode($data);
                            
                                $headers = [
                                    'Authorization: Bearer ' . $access_token,
                                    // 'Authorization: key=' . env('FIREBASE_SERVER_API_KEY'),
                                    'Content-Type: application/json',
                                ];
                            
                                $ch = curl_init();
                        
                                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/'.env('FIREBASE_PROJECT_ID').'/messages:send');
                                // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                                    
                                $response = curl_exec($ch);
                                Log::info($response);

                                // $um->has_notif = true;
                                // $um->update();
                                $um->delete();

                                $user->notif_ads_count++;
                                $user->update();
                            }
                        }
                    }
                }
            }
        });

        Log::info('Job AdsNotif Success ...');
    }   
}
