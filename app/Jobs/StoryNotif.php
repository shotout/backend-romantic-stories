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

    public function handle()
    {
        $story = Story::where('has_notif', false)->orderBy('id', 'asc')->first();

        if ($story) {  
            $SERVER_API_KEY = env('FIREBASE_SERVER_API_KEY');

            User::with('schedule')->whereHas('schedule')->where('notif_enable',1)->whereNotNull('fcm_token')
                ->chunkById(500, function (Collection $users) use ($story, $SERVER_API_KEY) {
                foreach ($users as $user) {
                    if ($user->schedule->counter_notif < 1) {
                        if ($user->schedule->timezone && now()->setTimezone($user->schedule->timezone)->format('H:i:s') >= '00:00:00' && now()->setTimezone($user->schedule->timezone)->format('H:i:s') <= '00:30:00') {

                            $data = [
                                "to" => $user->fcm_token,
                                "type" => "story",
                                "data" => [
                                    "id" => $story->id,
                                ],
                                "notification" => [
                                    "title" => "New story alert! 💥🔓",
                                    "body" => "Dive into our latest tale of passion and intrigue. Tap to read now!",
                                    "icon" => 'https://erotalesapp.com/assets/logo/favicon.jpg',
                                    "sound" => "circle.mp3",
                                    "badge" => $user->notif_count + 1
                                ]
                            ];
                            
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
                    } else {
                        // reset schedule counter
                        if ($user->schedule->timezone && now()->setTimezone($user->schedule->timezone)->format('H:i:s') >= '01:00:00' && now()->setTimezone($user->schedule->timezone)->format('H:i:s') <= '01:30:00') {
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
