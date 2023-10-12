<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan rabbitmq:publish
     * @var string
     */
    protected $signature = 'rabbitmq:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // создаём новое соединение с RabbitMQ-сервером
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password')
        );
        // создание канала на этом соединении
        $channel = $connection->channel();


        // следующие 3 метода обычно делаются в админ панели, а не в коде
        // Объявление обменника
        //$channel->exchange_declare('laravel_exch', 'direct', false, true, false);
        // Объявление очереди с именем 'laravel_que', Если такой очереди нет, она будет создана
        //$channel->queue_declare('laravel_que', false, true, false, false);
        // Привязка объявленной выше очереди 'laravel_que' к обменнику 'laravel_exch'
        //$channel->queue_bind('laravel_que', 'laravel_exch');

        $data = [
            'title'=>'заголовок',
            'content'=>'контент'
        ];

        $data_json = json_encode($data);

        $msg = new AMQPMessage($data_json);
        // Отправка сообщения на обменник 'laravel_exch'
        $channel->basic_publish($msg, 'laravel_exch');

        // Вывод информационного сообщения в консоль
        echo " Message sent \n";

        // Закрытие канала и соединения
        $channel->close();
        $connection->close();
    }
}
