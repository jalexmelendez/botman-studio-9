<?php

namespace Laravel\Telescope\Watchers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Events\NotificationSent;
use Laravel\Telescope\ExtractTags;
use Laravel\Telescope\FormatModel;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;

class NotificationWatcher extends Watcher
{
    /**
     * Register the watcher.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function register($app)
    {
        $app['events']->listen(NotificationSent::class, [$this, 'recordNotification']);
    }

    /**
     * Record a new notification message was sent.
     *
     * @param  \Illuminate\Notifications\Events\NotificationSent  $event
     * @return void
     */
    public function recordNotification(NotificationSent $event)
    {
        if (! Telescope::isRecording()) {
            return;
        }

        Telescope::recordNotification(IncomingEntry::make([
            'notification' => get_class($event->notification),
            'queued' => in_array(ShouldQueue::class, class_implements($event->notification)),
            'notifiable' => $this->formatNotifiable($event->notifiable),
            'channel' => $event->channel,
            'response' => $event->response,
        ])->tags($this->tags($event)));
    }

    /**
     * Extract the tags for the given event.
     *
     * @param  \Illuminate\Notifications\Events\NotificationSent  $event
     * @return array
     */
    private function tags($event)
    {
        return array_merge([
            $this->formatNotifiable($event->notifiable),
        ], ExtractTags::from($event->notification));
    }

    /**
     * Format the given notifiable into a tag.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    private function formatNotifiable($notifiable)
    {
        if ($notifiable instanceof Model) {
            return FormatModel::given($notifiable);
        } elseif ($notifiable instanceof AnonymousNotifiable) {
            $routes = array_map(function ($route) {
                return is_array($route) ? implode(',', $route) : $route;
            }, $notifiable->routes);

            return 'Anonymous:'.implode(',', $routes);
        }

        return get_class($notifiable);
    }
}
