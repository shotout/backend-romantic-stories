<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Story;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Database\Eloquent\Collection;

class StoryNotif implements ShouldQueue
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
        $story = Story::where('has_notif', false)->orderBy('id', 'asc')->first();

        if ($story) {  
            $SERVER_API_KEY = env('FIREBASE_SERVER_API_KEY');

            $desc = strip_tags($story->title_en);
            $filterDesc = html_entity_decode($desc);
            // $descShort = substr($filterDesc, 0, 100);
            $list_word = explode(" ", $filterDesc);
            $filter_word = array();
            foreach ($list_word as $key => $value) {
                if ($key <= 10) $filter_word[] = $value;
            }
            $descShort = implode(" ", $filter_word);

            User::with('schedule','subscription')->whereHas('schedule')->whereHas('subscription')->whereNotNull('fcm_token')
                ->chunkById(500, function (Collection $users) use ($story, $descShort, $SERVER_API_KEY) {
                foreach ($users as $user) {
                    // if ($user->schedule) {
                        if ($user->subscription->plan_id != 1 || $user->subscription->type != 1) {
                            if ($user->schedule->counter_notif < $user->schedule->often) {
                                if ($user->schedule->timezone && now()->setTimezone($user->schedule->timezone)->format('H:i:s') >= $user->schedule->start && now()->setTimezone($user->schedule->timezone)->format('H:i:s') <= Carbon::parse($user->schedule->end)->addMinute(10)->format('H:i:s')) {
                                    if ($user->schedule->timer) {
                                        if (in_array(now()->setTimezone($user->schedule->timezone)->format('H:i'), $user->schedule->timer)) {

                                            Log::info('ada ...');

                                            $data = [
                                                "to" => $user->fcm_token,
                                                "data" => [
                                                    "id" => $story->id,
                                                ],
                                                "notification" => [
                                                    // "title" => $user->name .", New story alert! 💥🔓",
                                                    // "body" =>  $descShort ."...",  
                                                    "title" => "New story alert! 💥🔓",
                                                    "body" => "Dive into our latest tale of passion and intrigue. Tap to read now!",
                                                    "icon" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                                    // "image" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                                    "sound" => "circle.mp3",
                                                    "badge" => $user->notif_count + 1
                                                ]
                                            ];
                                
                                            // Log::info($data);
                                
                                            $dataString = json_encode($data);
                                        
                                            $headers = [
                                                'Authorization: key=' . $SERVER_API_KEY,
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

                                            // update user schedule
                                            $user->schedule->counter_notif++;
                                            $user->schedule->update();

                                            // update user
                                            $user->notif_count++;
                                            $user->update();
                                            
                                        }
                                    }
                                }
                            } else {
                                // reset schedule counter
                                if ($user->schedule->timezone && now()->setTimezone($user->schedule->timezone)->format('H:i:s') >= '00:00:00' && now()->setTimezone($user->schedule->timezone)->format('H:i:s') <= '01:00:00') {
                                    $user->schedule->counter_notif = 0;
                                    $user->schedule->update();
                                }
                            }
                        } else {
                            if ($user->schedule->counter_notif < $user->schedule->often) {
                                if ($user->schedule->timezone && now()->setTimezone($user->schedule->timezone)->format('H:i:s') >= $user->schedule->start && now()->setTimezone($user->schedule->timezone)->format('H:i:s') <= Carbon::parse($user->schedule->end)->addMinute(10)->format('H:i:s')) {
                                    if ($user->schedule->timer) {
                                        if (in_array(now()->setTimezone($user->schedule->timezone)->format('H:i'), $user->schedule->timer)) {

                                            Log::info('ada ...');

                                            $data = [
                                                "to" => $user->fcm_token,
                                                "data" => [
                                                    "id" => $story->id,
                                                ],
                                                "notification" => [
                                                    "title" => "New story alert! 💥🔓",
                                                    "body" => "Dive into our latest tale of passion and intrigue. Tap to read now!",
                                                    "icon" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                                    // "image" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                                    "sound" => "circle.mp3",
                                                    "badge" => $user->notif_count + 1
                                                ]
                                            ];

                                            // Log::info($data);

                                            $dataString = json_encode($data);

                                            $headers = [
                                                'Authorization: key=' . $SERVER_API_KEY,
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

                                            // update user schedule
                                            $user->schedule->counter_notif++;
                                            $user->schedule->update();

                                            // update user
                                            $user->notif_count++;
                                            $user->update();

                                        }
                                    }
                                }
                            } else {
                                // reset schedule counter
                                if ($user->schedule->timezone && now()->setTimezone($user->schedule->timezone)->format('H:i:s') >= '00:00:00' && now()->setTimezone($user->schedule->timezone)->format('H:i:s') <= '01:00:00') {
                                    $user->schedule->counter_notif = 0;
                                    $user->schedule->update();
                                }
                            }
                        }
                    // }
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
