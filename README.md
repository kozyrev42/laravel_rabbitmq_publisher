1. установил пакет
   `composer require php-amqplib/php-amqplib`

2. создадим консольную команду:
   `php artisan make:command PublishCommand`

3. команда отправляет сообщение в Рэббит

4. новый класс для канала уведомления
`php artisan make:channel RabbitMQChannel`

- создадим уведомление:
`php artisan make:notification PostPublishedNotification`

- создадим консольную команду, которая будет отправлять уведомление
`php artisan make:command TestNotification`

- отправка сообщений по средствам канала RabbitMQChannel
