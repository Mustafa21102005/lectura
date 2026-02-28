<?php

namespace App\Console\Commands;

use App\Models\Assignment;
use App\Notifications\AssignmentDeadlineReminder;
use Illuminate\Console\Command;

class SendAssignmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assignments:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send 24-hour reminders before assignment due dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $reminderCount = 0;

        $assignments = Assignment::with(['reminderStatuses.student'])->get();

        foreach ($assignments as $assignment) {
            $due = $assignment->due_date;

            // Only process if due in ≤ 24 hours
            if (!$now->greaterThanOrEqualTo($due->copy()->subDay())) {
                continue;
            }

            // Keep reminder table synced
            $assignment->syncStudents();

            // Reload fresh reminder rows
            $assignment->load('reminderStatuses.student');

            foreach ($assignment->reminderStatuses as $reminder) {

                // If student missing → mark sent and skip
                if (!$reminder->student) {
                    $reminder->update([
                        'sent' => true,
                        'sent_at' => now(),
                    ]);
                    continue;
                }

                // Send reminder if not already sent
                if (!$reminder->sent) {
                    $reminder->student->notify(new AssignmentDeadlineReminder($assignment));

                    $reminder->update([
                        'sent'    => true,
                        'sent_at' => now(),
                    ]);

                    $reminderCount++;
                }
            }
        }

        $this->info("Sent {$reminderCount} reminders.");
    }
}
