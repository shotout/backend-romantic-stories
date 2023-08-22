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

class GenerateTimerAds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = User::with('schedule')->find($user);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->user) {
            UserMessage::where('user_id', $this->user->id)->delete();

            $messages = Message::where('type', 1)->where('status', 2)->get();

            foreach ($messages as $message) {
                $time = now()->addMinute($message->time)
                    ->setTimezone($this->user->schedule->timezone)
                    ->format('Y-m-d H:i:s');

                $um = new UserMessage;
                $um->user_id = $this->user->id;
                $um->message_id = $message->id;
                $um->time = $time;
                $um->save();
            }

            Log::info('Job GenerateTimerAds Success ...');
        }
    }
}
