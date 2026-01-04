<?php

namespace Rutul\MassUsersPasswordReset\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $newPassword,
        public ?string $initiatorName = null
    ) {
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
        $message = (new MailMessage)
            ->subject('Your Password Has Been Reset')
            ->line('Your password has been reset by an administrator.')
            ->line('Your new temporary password is: **' . $this->newPassword . '**')
            ->line('Please log in and change your password immediately for security reasons.')
            ->action('Log In', url('/login'))
            ->line('If you did not request this password reset, please contact support immediately.');

        if ($this->initiatorName) {
            $message->line('This action was performed by: ' . $this->initiatorName);
        }

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
            'password_reset' => true,
            'new_password' => $this->newPassword,
            'initiated_by' => $this->initiatorName,
        ];
    }
}

