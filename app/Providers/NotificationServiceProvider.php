<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use App\Broadcasting\RabbitMQChannel;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Регистрируем кастомный канал уведомлений RabbitMQ
        Notification::extend('rabbitmq', function ($app) {
            return new RabbitMQChannel();
        });
    }
}
