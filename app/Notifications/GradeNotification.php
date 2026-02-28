<?php

namespace App\Notifications;

use App\Models\Grade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GradeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Grade $grade, protected string $type = 'new')
    {
        $this->grade = $grade;
        $this->type = $type;
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
        $assignment = $this->grade->submission->assignment;
        $subject = $this->type === 'new'
            ? 'Your Assignment Has Been Graded'
            : 'Your Grade Has Been Updated';

        $message = (new MailMessage)
            ->subject($subject)
            ->greeting("Hello {$notifiable->name},")
            ->line("Your assignment **{$assignment->title}** has been " .
                ($this->type === 'new' ? 'graded' : 'updated') . ".")
            ->line("**Score:** {$this->grade->score} / {$assignment->max_score}")
            ->when(
                !empty($this->grade->remarks),
                fn($msg) =>
                $msg->line("**Teacher’s Remarks:** {$this->grade->remarks}")
            )
            ->action('View Your Grade', route('grades.show', $this->grade->id))
            ->line('You are receiving this email because you have grade notifications enabled.')
            ->salutation('Thanks, ' . config('app.name') . ' Team');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
