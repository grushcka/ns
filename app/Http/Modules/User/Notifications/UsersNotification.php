<?php

namespace NS\User\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\{Carbon, Facades\Config, Facades\Lang, Facades\URL};

class UsersNotification extends VerifyEmail
{
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'user.verification.verify',
            Carbon::now()->addMinutes(Config::get('user::verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(Config::get('mail.from.address'))
            ->subject(Lang::get('Verify Email Address'))
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify Email Address'), $this->verificationUrl($notifiable))
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }
}
