<?php

namespace App\Broadcasting;

use Exception;
use Illuminate\Notifications\Notification;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class RabbitMQChannel
 *
 * Класс, отвечающий за отправку уведомлений через канал RabbitMQ.
 *
 * @package App\Broadcasting
 */
class RabbitMQChannel
{
    /**
     * Отправляет уведомление через канал RabbitMQ.
     *
     * @param mixed $notifiable Объект, который следует уведомить.
     * @param Notification $notification Уведомление, которое следует отправить.
     *
     * @return void
     * @throws Exception
     */
    public function send($notifiable, Notification $notification)
    {
        // Преобразование уведомления в строку сообщения для RabbitMQ.
        $message = $notification->toRabbitMQ($notifiable);

        // Установление соединения с сервером RabbitMQ, используя параметры из конфигурационного файла.
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password')
        );
        $channel = $connection->channel();

        // Создание и настройка сообщения AMQP.
        $msg = new AMQPMessage($message);

        // Отправка сообщения в RabbitMQ в обменник 'laravel_exch'.
        $channel->basic_publish($msg, 'laravel_exch');

        // Закрытие канала и соединения.
        $channel->close();
        $connection->close();
    }
}
