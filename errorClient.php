<?php
//thisgoesupthere^^ #!/usr/bin/php
echo "argv 1:  ". $argv[1]. PHP_EOL;
echo "argv 2:  ". $argv[2]. PHP_EOL;
echo "argv 3:  ". $argv[3]. PHP_EOL;
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//echo "we are about to connect" . PHP_EOL;

$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "error";

$request['errorType'] = $argv[1];
$request['errorMsg'] = $argv[2];
$request['errorId'] = $argv[3];

$request['message'] = $msg;


$response = $client->send_request($request);

return $response;

?>
