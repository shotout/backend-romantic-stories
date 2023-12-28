<?php

namespace App\Jobs;

use App\Models\Rating;
use App\Models\PastStory;
use App\Models\UserAudio;
use App\Models\UserTrack;
use App\Models\Collection;
use App\Models\StoryRating;
use Illuminate\Bus\Queueable;
use App\Models\CollectionStory;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UserReset implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        PastStory::where('user_id', $this->user)->delete();
        StoryRating::where('user_id', $this->user)->delete();
        Rating::where('user_id', $this->user)->delete();
        UserAudio::where('user_id', $this->user)->delete();
        UserTrack::where('user_id', $this->user)->delete();
        Collection::where('user_id', $this->user)->delete();
        CollectionStory::where('user_id', $this->user)->delete();

        GenerateTimer::dispatch($this->user)->onQueue(env('SUPERVISOR'));

        Log::info('Job UserReset Success ...');
    }
}
