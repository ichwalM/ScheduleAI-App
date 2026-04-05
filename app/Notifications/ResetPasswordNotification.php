<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Reset Password — ScheduleAI')
            ->markdown('mail.reset-password', [
                'url'      => $url,
                'name'     => $notifiable->name,
                'email'    => $notifiable->email,
                'expiry'   => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
            ]);
    }
}
