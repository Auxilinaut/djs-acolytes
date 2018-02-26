#!/usr/bin/php
<?php
include('../connections/rabbitconnection.php');
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$exchange = 'testexchange';
$queue = 'testqueue';
$consumerTag = 'consumer';

$connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
$channel = $connection->channel();

/*
    The following code is the same both in the consumer and the producer.
    In this way we are sure we always have a queue to consume from and an
        exchange where to publish messages.
*/

/*
    name: $queue
    passive: false
    durable: true // the queue will survive server restarts
    exclusive: false // the queue can be accessed in other channels
    auto_delete: false //the queue won't be deleted once the channel is closed.
*/

//$channel->queue_declare('testqueue', false, false, false, false);
$channel->queue_declare('testqueue', false, true, false, false);

/*
    name: $exchange
    type: direct
    passive: false
    durable: true // the exchange will survive server restarts
    auto_delete: false //the exchange won't be deleted once the channel is closed.
*/

$channel->exchange_declare($exchange, 'topic', false, true, false);

$channel->queue_bind($queue, $exchange);

$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();
?>
