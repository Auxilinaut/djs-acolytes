#!/usr/bin/php
<?php
include('../connections/rabbitconnection.php');
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
$channel = $connection->channel();


//$channel->queue_declare('testqueue', false, false, false, false);
$channel->queue_declare('testqueue', false, true, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg) {
  echo " [x] Received ", $msg->body, "\n";
};

$channel->basic_consume('testqueue', '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

?>

