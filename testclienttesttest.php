<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
echo "we are about to connect" . PHP_EOL;
$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
echo "we made client" . PHP_EOL;
$msg = "test message";
$request = array();
$request['message'] = $msg;
echo "hello";
$response = $client->send_request($request);
//$response = $client->publish($request);
echo "client received response: " . PHP_EOL;
print_r($response);
echo "\n\n";
echo $argv[0]." END".PHP_EOL;
?>
