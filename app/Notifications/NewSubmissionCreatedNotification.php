<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewSubmissionCreatedNotification extends Notification
{
    use Queueable;

    public $submission;

    /**
     * Constructor
     */
    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    /**
     * Canales de notificación
     */
    public function via(object $notifiable): array
    {
        return ['database'];
        // Si luego quieres correo:
        // return ['database', 'mail'];
    }

    /**
     * Datos que se guardan en la BD
     */
    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'title' => $this->submission->title,
            'author_name' => $this->submission->author->name ?? 'Autor',
            'status' => $this->submission->status,
            'message' => 'Nuevo documento enviado y pendiente de asignación.',
            'url' => url('/submissions/' . $this->submission->id),
        ];
    }

    /**
     * (Opcional) Correo
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuevo documento recibido')
            ->line('Se ha recibido un nuevo documento.')
            ->line('Título: ' . $this->submission->title)
            ->action('Ver documento', url('/submissions/' . $this->submission->id));
    }
}