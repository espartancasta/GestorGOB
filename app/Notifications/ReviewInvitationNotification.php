<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewInvitationNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Submission $submission,
        private readonly string $token
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'title' => $this->submission->title,
            'message' => 'Tienes una invitacion pendiente para revisar un documento.',
            'url' => url('/review-invite/' . $this->token),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Invitacion para revisar documento')
            ->line('Tienes una invitacion pendiente para revisar un documento.')
            ->line('Titulo: ' . $this->submission->title)
            ->action('Ver invitacion', url('/review-invite/' . $this->token));
    }
}
