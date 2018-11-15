<?php

namespace App\Notifications\Kernel;


use App\Models\NotificationTemplate;
use App\Models\User;
use App\Notifications\Messages\SmsMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Support\Facades\Lang;

trait Template
{

    /**
     * Get action object
     *
     * @var array|bool
     */
    public $action;

    /**
     * Email Template
     *
     * @var NotificationTemplate
     */
    public $template;

    /**
     * Get the notification's delivery channels.
     *
     * @param  User $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $this->replacement = $this->replacement($notifiable);

        $channels = json_decode(self::getChannels(), true);

        if (method_exists($this, 'customChannels')){
            $channels = array_intersect(
                $channels, $this->customChannels($notifiable)
            );
        }

        return $channels;
    }


    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->setLangReplacement($notifiable);
        $this->setTemplateMailAction($notifiable);

        $message = (new MailMessage())
            ->level($this->template->level)
            ->subject(__($this->template->subject, $this->replacement))
            ->markdown('markdown.email.default', [
                'template' => $this->template,
                'action' => $this->action,
                'replacement' => $this->replacement
            ]);

        return $message;
    }

    /**
     * Get the email action button
     *
     * @return array|boolean
     */
    public function setTemplateMailAction($notifiable)
    {
        if ($this->template->action_editable) {
            $action = $this->template->action;
        } else {
            $action = $this->getMailAction($notifiable);
        }

        $this->action = json_decode($action, true);
    }

    /**
     * Set language replacements
     *
     * @param $notifiable
     */
    public function setLangReplacement($notifiable)
    {
        $this->replacement = $this->replacement($notifiable);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $this->setLangReplacement($notifiable);
        $this->setTemplateMailAction($notifiable);

        switch (self::$level) {
            case 'success':
                $class = 'bg-success';
                break;

            case 'info':
                $class = 'bg-info';
                break;

            case 'error':
                $class = 'bg-danger';
                break;

            default:
                $class = 'bg-secondary';
                break;
        }

        return [
            'subject' => __($this->template->subject, $this->replacement),
            'message' => __($this->template->message, $this->replacement),
            'icon_class' => "ft-bell icon-bg-circle {$class}",
            'link' => $this->action['url'] ?? '#',
        ];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        $this->setLangReplacement($notifiable);

        return (new NexmoMessage())
            ->content(__($this->template->message, $this->replacement));
    }

    /**
     * Get the Other / SMS representation of the notification.
     *
     * @param $notifiable
     * @return SmsMessage
     */
    public function toSms($notifiable)
    {
        $this->setLangReplacement($notifiable);

        return (new SmsMessage())
            ->content(__($this->template->message, $this->replacement));
    }

    /**
     * Get the configuration instance for
     * this notification
     *
     * @return Configuration
     */
    public static function getConfiguration()
    {
        $template = self::$template_name;

        $config = new Configuration($template, [
            'level' => self::$level,
            'action_editable' => self::$action_editable,
            'channels' => self::getChannels(),
        ], self::parameters());

        return $config;
    }

    /**
     * Get json encoded value of the channels
     * array
     *
     * @return string
     */
    private static function getChannels()
    {
        $channels = [];

        if (in_array('sms', self::$channels)) {
            array_push($channels, getSmsChannel());
        }

        if (in_array('database', self::$channels)) {
            array_push($channels, 'database');
        }

        if (in_array('mail', self::$channels)) {
            array_push($channels, 'mail');
        }

        return json_encode($channels);
    }
}
