<?php

namespace App\Console\Commands;

use App\Notifications\PostPublishedNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\Notifiable;

class TestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan notification:test
     * @var string
     */
    protected $signature = 'notification:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'тест отправки уведомления';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Создание анонимного объекта для отправки уведомления
        $notifiable = new class {
            use Notifiable;

            public function routeNotificationForRabbitMQ()
            {
                // Здесь можно указать специфическую логику маршрутизации, если необходимо
                // Например, возвращение имени очереди или маршрута. В этом примере просто возвращаем null.
                return null;
            }
        };

        $postData = [
            'title' => 'Захардкоженный пост',
            'content' => 'Содержимое захардкоженного поста',
        ];

        $notifiable->notify(new PostPublishedNotification($postData));

        $this->info('Уведомление отправлено!');
    }
}
