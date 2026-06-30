<?php

namespace App\Notifications;

use App\Models\SubmissionReviewer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewProblemNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly SubmissionReviewer $invite,
        private readonly string $reason
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        $submission = $this->invite->submission;
        $message = $this->reason === 'rejected'
            ? 'Un revisor rechazo la invitacion.'
            : 'Una invitacion de revision expiro.';

        return [
            'submission_id' => $submission?->id,
            'reviewer_id' => $this->invite->reviewer_id,
            'reason' => $this->reason,
            'title' => $submission?->title,
            'message' => $message,
            'url' => $submission ? url('/submissions/' . $submission->id) : url('/submissions-pending'),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $submission = $this->invite->submission;

        return (new MailMessage)
            ->subject('Atencion requerida en revision')
            ->line($this->reason === 'rejected'
                ? 'Un revisor rechazo la invitacion.'
                : 'Una invitacion de revision expiro.')
            ->line('Documento: ' . ($submission?->title ?? 'Sin titulo'))
            ->action('Ver documento', $submission ? url('/submissions/' . $submission->id) : url('/submissions-pending'));
    }
}
