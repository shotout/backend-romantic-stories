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
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Database\Eloquent\Collection;

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
        // $users = User::with('schedule')->where('is_member', 0)->where('status', 2)->get();

        User::with('schedule')->where('is_member', 0)->where('status', 2)
            ->chunkById(500, function (Collection $users) {

            foreach ($users as $user) {
                if ($user->schedule) {
                    $time = now()->setTimezone($user->schedule->timezone);

                    $um = UserMessage::where('user_id', $user->id)
                        ->where('has_notif', false)
                        ->whereDate('time', $time)
                        ->whereTime('time', '<=', $time)
                        ->first();

                    if ($um) {
                        $message = Message::find($um->message_id);
                        if ($message) {
                            
                            $boxs = [
                                "name" => $user->name,
                                "selected_goal" => "selected_goal"
                                // "selected_goal" => $user->areas[0]->name
                            ];

                            foreach ($boxs as $key => $val) {
                                $descShort = str_replace('['.$key.']', $val, $message->push_text);
                            }
                            $descShort = str_replace('[name]', $user->name, $descShort);

                            $placement = null;
                            if (in_array($message->id, array(1,2))) {
                                $placement = "offer_no_purchase_after_onboarding_paywall";
                            } else {
                                $placement = "offer_no_purchase_after_onboarding_paywall_2nd";
                            }

                            $data = [
                                "to" => $user->fcm_token,
                                "data" => (object) array(
                                    "type" => "paywall",
                                    // "placement" => "offer_no_purchase_after_onboarding_paywall",
                                    "placement" => $placement,
                                    "message_count" => $message->id
                                ),
                                "notification" => [
                                    "title" => "McSmart App",
                                    "body" => $descShort,  
                                    // "title" => "A new Affirmation is waiting for you ✨",
                                    // "body" => "Click here to get inspired and discover your new Quote. Don’t lose your progress. 🌟💪",  
                                    "icon" => 'https://backend-api.mcsmartapp.com/assets/logos/logo.jpg',
                                    "sound" => "circle.mp3",
                                    "badge" => $user->notif_count + 1
                                ]
                            ];
                
                            Log::info($data);
                
                            $dataString = json_encode($data);
                        
                            $headers = [
                                'Authorization: key=' . env('FIREBASE_SERVER_API_KEY'),
                                'Content-Type: application/json',
                            ];
                        
                            $ch = curl_init();
                    
                            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                                
                            $response = curl_exec($ch);
                            Log::info($response);

                            $um->has_notif = true;
                            $um->update();

                            $user->notif_ads_count++;
                            $user->update();
                        }
                    }
                }
            }
        });

        Log::info('Job AdsNotif Success ...');
    }   
}
