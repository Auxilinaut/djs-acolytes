<?php
//thisgoesupthere^^ #!/usr/bin/php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//echo "we are about to connect" . PHP_EOL;

$client = new rabbitMQClient("DatabaseRMQ.ini", "Database");

//echo "we made client" . PHP_EOL;

if (isset($argv[1]))
{
  $msg = $argv[1];
}

$request = array();
$request['type'] = "chatSend";
$request['message'] = $_POST["txt"];
$request['sessionid'] = $_POST["sid"];
$request['tournamentid'] = $_POST["id"];


if (isset($msg))
{
  $request['message'] = $msg;
}

$sessionid = $client->send_request($request);

print "$sessionid";

?>
