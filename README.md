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

5. генерация класс События (Инициализация/определение события, которое будет прослушиваться Слушателем)
`php artisan make:event PostCreated`


- создание слушателя SendPostCreatedNotification.php (в слушателе будет выполняться какая-либо логика в ответ на событие):
`php artisan make:listener SendPostCreatedNotification --event=PostCreated`


- в EventServiceProvider.php -> Регистрация Слушателя и События


- в NotificationServiceProvider.php -> Регистрируем кастомный канал уведомлений RabbitMQ


- в PostController.php -> Генерация события сразу после записи в базу
