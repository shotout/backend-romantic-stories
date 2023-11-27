<?php

namespace App\Jobs;

use App\Models\Pool;
use App\Models\MyStory;
use App\Models\Story;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UserPoolStory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // user pools
        $pools = Pool::where('user_id', $this->user->id)->get();

        // count story percentage
        $totalStory = Story::count();
        $counter = $totalStory / 100;
        $myStory = array();

        foreach ($pools as $pool) {
            $qty = round($pool->total);
            $takeStory = $qty * $counter;
            $countStory = Story::where('category_id', $pool->category_id)->count();
            if ($takeStory > $countStory) $pool->story = $countStory;
            else $pool->story = $takeStory;
            $pool->save();

            $stories = Story::orderBy('id', 'asc')
                ->where('category_id', $pool->category_id)
                ->take($pool->story)
                ->pluck('id')
                ->toArray();
            foreach ($stories as $story) {
                $myStory[] = $story;
            }
        }

        // rules
        if ($this->user->category_id == 1) $rules = [1,2,1,3,1,2,1,3,1,1];
        if ($this->user->category_id == 2) $rules = [2,1,2,3,2,1,2,3,2,2];
        if ($this->user->category_id == 3) $rules = [3,1,3,2,3,1,3,2,3,3];
        if ($this->user->category_id == 4) $rules = [1,2,3,1,2,3,1,2,3,1];

        // my story
        $ms = MyStory::where('user_id', $this->user->id)->first();
        if (!$ms) $ms = new MyStory;

        $ms->user_id = $this->user->id;
        $ms->total_story = $totalStory;
        $ms->take_story = count($myStory);
        // $ms->stories = $myStory;
        $ms->rules = $rules;
        $ms->save();

        GenerateTimer::dispatch($this->user->id)->onQueue(env('SUPERVISOR'));
        Log::info('Job UserPoolStory Success ...');
    }
}
