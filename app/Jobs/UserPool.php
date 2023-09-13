<?php

namespace App\Jobs;

use App\Models\Pool;
use App\Models\User;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UserPool implements ShouldQueue
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
        $categories = Category::whereNot('id', 4)->where('status', 2)->get();

        if (count($categories)) {
            foreach ($categories as $category) {
                $pool = Pool::where('user_id', $this->user->id)->where('category_id', $category->id)->first();
                if (!$pool) $pool = new Pool;
                
                $pool->user_id = $this->user->id;
                $pool->category_id = $category->id;
                if ($this->user->category_id != 4) $pool->total = $this->user->category_id == $category->id ? 60 : 20;
                else $pool->total = 33;
                $pool->save();
            }
        }

        UserPoolStory::dispatch($this->user)->onQueue(env('SUPERVISOR'));
        Log::info('Job UserPool Success ...');
    }
}
