<?php

namespace App\Console\Commands;

use App\Models\Offense;
use App\Models\SaProfile;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckEndDateProbation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sa-end-probation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update SA probation status when end date has passed.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Find SAs where offense end date is past today and status is still on probation
        $withProbation = Offense::where('status', 'probation')->where('end_date', '<', $today)->get();

        $updatedCount = 0;

        foreach ($withProbation as $sa) {
            // Update SA status (e.g., setting it back to active or cleared)
            SaProfile::where('user_id', $sa->user_id )->update(['status' => 'active']);
            $sa->delete();
            $updatedCount++;
        }

        // Log how many SAs were updated
        Log::info("Probation check completed: {$updatedCount} SAs status updated.");
        $this->info("Probation check completed: {$updatedCount} SAs status updated.");
    }
}
