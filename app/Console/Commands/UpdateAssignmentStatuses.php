<?php

namespace App\Console\Commands;

use App\Models\Assignment;
use Illuminate\Console\Command;

class UpdateAssignmentStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assignments:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update assignment statuses based on due dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        // ON-TIME → LATE
        $lateUpdated = Assignment::where('status', 'on-time')
            ->where('due_date', '<', $now)
            ->update(['status' => 'late']);

        // LATE → CLOSED (1 week after due date)
        $closedUpdated = Assignment::where('status', 'late')
            ->where('due_date', '<', $now->copy()->subWeek())
            ->update(['status' => 'closed']);

        $this->info("Updated " . ($lateUpdated + $closedUpdated) . " assignments.");
    }
}
