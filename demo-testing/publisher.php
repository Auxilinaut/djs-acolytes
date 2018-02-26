#!/usr/bin/php
<?php
/*https://github.com/php-amqplib/php-amqplib/tree/master/demo*/

include("../vendor/autoload.php");
include("../connections/rabbitconnection.php");

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$exchange = 'testexchange';
$queue = 'testqueue';

$connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
$channel = $connection->channel();

/*
    passive: false
    durable: true // the queue will survive server restarts
    exclusive: false // the queue can be accessed in other channels
    auto_delete: false //the queue won't be deleted once the channel is closed.
*/
$channel->queue_declare($queue, false, true, false, false);

/*
    name: $exchange
    type: direct
    passive: false
    durable: true // the exchange will survive server restarts
    auto_delete: false //the exchange won't be deleted once the channel is closed.
*/

$channel->exchange_declare($exchange, 'topic', false, true, false);

$channel->queue_bind($queue, $exchange);

//$messageBody = implode(' ', array_slice($argv, 1));
$messageBody = json_encode([
    'email' => 'jo75@njit.edu',

    'subscribed' => true,
]);

$message = new AMQPMessage($messageBody, ['content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
$channel->basic_publish($message, $exchange);

$channel->close();
$connection->close();

