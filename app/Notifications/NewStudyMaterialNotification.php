<?php

namespace App\Notifications;

use App\Models\StudyMaterial;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewStudyMaterialNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public int $materialId, public string $studentName)
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
        $material = StudyMaterial::findOrFail($this->materialId);

        return (new MailMessage)
            ->subject('New Study Material Added')
            ->greeting("Hello {$this->studentName},")
            ->line("A new study material has been uploaded by your teacher:")
            ->line("**{$material->title}**")
            ->when(!empty($material->description), function (MailMessage $mail) use ($material) {
                $mail->line('About this material:')
                    ->line($material->description);
            })
            ->action('View Material', route('study-materials.show', $material))
            ->line('You are receiving this email because you have opted in to receive notifications for new study materials on ' . config('app.name') . '. If you didn’t expect this email, you can safely ignore it.')
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
