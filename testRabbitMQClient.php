#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

echo "we are about to connect" . PHP_EOL;

$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

echo "we made client" . PHP_EOL;

if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "login";
//$request['username'] = $_POST["uname"];
//$request['password'] = $_POST["pword"];

$request['username'] = "Beni";
$request['password'] = "newbie";

echo "              request uname " . $request['username'] . PHP_EOL;
echo "              request pword " . $request['password'] . PHP_EOL;


$request['message'] = $msg;
//$response = $client->send_request($request);
$response = $client->publish($request);

echo "client received response: " . PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;
?>
