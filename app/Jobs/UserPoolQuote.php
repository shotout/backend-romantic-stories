<?php

namespace App\Jobs;

use App\Models\Pool;
use App\Models\User;
use App\Models\Quote;
use App\Models\MyQuote;
use App\Models\PastQuote;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UserPoolQuote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->user = User::find($id);
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

        // list past quote user
        $pastQuotes = PastQuote::where('user_id', $this->user->id)
            ->pluck('quote_id')
            ->toArray();

        // count quote percentage
        $totalQuote = Quote::count();
        $counter = round($totalQuote / 100);

        $myQuotes = array();

        foreach ($pools as $pool) {
            $qty = round($pool->total);
            $takeQuote = $qty * $counter;
            $countQuote = Quote::where('category_id', $pool->category_id)->count();
            if ($takeQuote > $countQuote) {
                $pool->quote = $countQuote;
            } else {
                $pool->quote = $takeQuote;
            }
            $pool->save();

            $quotes = Quote::orderBy('order', 'asc')
                ->where('category_id', $pool->category_id)
                ->whereNotIn('id', $pastQuotes)
                ->take($pool->quote)
                ->pluck('id')
                ->toArray();
            foreach ($quotes as $quote) {
                $myQuotes[] = $quote;
            }
        }

        // my quotes
        $mc = new MyQuote;
        $mc->user_id = $this->user->id;
        $mc->totalQuote = $totalQuote;
        $mc->takeQuote = count($myQuotes);
        $mc->quotes = $myQuotes;
        $mc->save();

        GenerateTimer::dispatch($this->user->id)->onQueue(env('SUPERVISOR'));
        Log::info('Job UserPoolQuote Success ...');
    }
}
