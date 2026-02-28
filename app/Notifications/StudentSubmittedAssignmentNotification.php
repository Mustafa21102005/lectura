<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentSubmittedAssignmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Submission $submission)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $student = $this->submission->student->name ?? 'A student';
        $assignment = $this->submission->assignment;

        return (new MailMessage)
            ->subject('📩 New Submission: ' . $assignment->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line("{$student} has just submitted their work for **{$assignment->title}**.")
            ->line('You can review and grade it using the link below.')
            ->action('View Submission', route('submissions.show', $this->submission->id))
            ->salutation('Thanks, ' . config('app.name') . ' Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'assignment_title' => $this->submission->assignment->title,
            'student_name' => $this->submission->student->name,
        ];
    }
}
