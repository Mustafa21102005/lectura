<?php

namespace App\Notifications;

use App\Models\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeacherAssignedToSubjectNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Subject $subjectModel, public string $teacherName)
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
        return (new MailMessage)
            ->subject("New Subject Assigned – {$this->subjectModel->name}")
            ->greeting("Hello {$this->teacherName},")
            ->line("We're excited to let you know you've been assigned a new subject:")
            ->line("**{$this->subjectModel->name}**")
            ->action('View Subject', route('subjects.show', $this->subjectModel))
            ->line('You are recieving this email because you have opted in to receive notifications for new subjects on our platform. If you did not expect this email, you can safely ignore it.')
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
            //
        ];
    }
}
