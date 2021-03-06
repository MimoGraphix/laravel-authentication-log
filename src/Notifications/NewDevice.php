<?php

namespace Yadahan\AuthenticationLog\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Yadahan\AuthenticationLog\AuthenticationLog;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class NewDevice extends Notification implements ShouldQueue
{
    /**
     * The authentication log.
     *
     * @var \Yadahan\AuthenticationLog\AuthenticationLog
     */
    public $authenticationLog;

    /**
     * Create a new notification instance.
     *
     * @param  \Yadahan\AuthenticationLog\AuthenticationLog  $authenticationLog
     * @return void
     */
    public function __construct(AuthenticationLog $authenticationLog)
    {
        $this->authenticationLog = $authenticationLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->notifyAuthenticationLogVia();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject( trans( 'authentication-log.email-subject', ['app' => config('app.name') ] ))
            ->markdown( config( 'authentication-log.email-view' ), [
                'account' => $notifiable,
                'time' => $this->authenticationLog->login_at,
                'ipAddress' => $this->authenticationLog->ip_address,
                'os' => $this->authenticationLog->getOs(),
                'browser' => $this->authenticationLog->getBrowser(),
                'location' => $this->authenticationLog->location,
                'comparison_hash' => $this->authenticationLog->comparison_hash,
            ]);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->from( config('app.name') )
            ->warning()
            ->content(trans('authentication-log.message-content', ['app' => config('app.name')]))
            ->attachment(function ($attachment) use ($notifiable) {
                $attachment->fields([
                    'Account' => $notifiable->email,
                    'Time' => $this->authenticationLog->login_at->toCookieString(),
                    'IP Address' => $this->authenticationLog->ip_address,
                    'Browser' => $this->authenticationLog->user_agent,
                ]);
            });
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content(trans('authentication-log.message-content', ['app' => config('app.name')]));
    }
}
