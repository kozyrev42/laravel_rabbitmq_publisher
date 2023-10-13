<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Broadcasting\RabbitMQChannel;

class PostPublishedNotification extends Notification
{
    use Queueable;

    protected $postData;

    public function __construct($postData)
    {
        $this->postData = $postData;
    }

    public function via($notifiable)
    {
        return [RabbitMQChannel::class];
    }

    public function toRabbitMQ($notifiable)
    {
        return json_encode([
            'title' => $this->postData['title'],
            'content' => $this->postData['content'],
        ]);
    }

}
