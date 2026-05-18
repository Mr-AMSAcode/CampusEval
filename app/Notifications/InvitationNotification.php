<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class InvitationNotification extends Notification
{
    use Queueable;

    public function __construct(protected string $token)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Invitation CampusEval')
            ->greeting("Bonjour {$notifiable->first_name},")
            ->line('Vous avez été invité(e) à rejoindre CampusEval en tant que membre du personnel ou enseignant.')
            ->action('Compléter votre profil', route('invitation.show', ['token' => $this->token]))
            ->line('Ce lien est valide pendant 7 jours. Après acceptation, vous pourrez accéder au tableau de bord de CampusEval.')
            ->line('Si vous n’avez pas demandé cette invitation, ignorez ce message.');
    }
}
