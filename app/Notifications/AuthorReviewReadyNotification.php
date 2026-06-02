<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AuthorReviewReadyNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Submission $submission)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'title' => $this->submission->title,
            'message' => 'Tus revisiones ya están listas para corrección.',
            'url' => url('/submissions/' . $this->submission->id),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tus revisiones están listas')
            ->line('Tus dos revisiones han sido entregadas y el documento está listo para corrección.')
            ->line('Ingresa al sistema para revisar los comentarios y hacer las correcciones necesarias.')
            ->action('Ver documento', url('/submissions/' . $this->submission->id));
    }
}
