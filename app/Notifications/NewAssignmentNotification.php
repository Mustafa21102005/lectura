<?php

namespace App\Notifications;

use App\Models\Assignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAssignmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Assignment $assignment)
    {
        $this->assignment = $assignment;
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
        return (new MailMessage)
            ->subject('📘 New Assignment Posted: ' . $this->assignment->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new assignment has been posted by your teacher.')
            ->line('**Title:** ' . $this->assignment->title)
            ->line('**Due Date:** ' . ($this->assignment->due_date))
            ->action('View Assignment', route('assignments.show', $this->assignment->slug))
            ->line('Good luck!')
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
            'assignment_id' => $this->assignment->id,
            'title' => $this->assignment->title,
            'teacher' => $this->assignment->teacher->name ?? 'Unknown Teacher',
        ];
    }
}
