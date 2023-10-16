<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Notifications\PostPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;

class SendPostCreatedNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        // Получаем пост из события
        $post = $event->post;

        // Уведомляем используя канал RabbitMQ
        $notifiable = new AnonymousNotifiable;
        $notifiable->route('rabbitmq', null)
            ->notify(new PostPublishedNotification($post));
    }
}
