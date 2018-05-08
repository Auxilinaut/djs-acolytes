
<?php
//thisgoesupthere^^ #!/usr/bin/php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//echo "we are about to connect" . PHP_EOL;

$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

//echo "we made client" . PHP_EOL;

if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
if (isset($_POST['tid']))
{
  $request['tid'] = $_POST['tid'];
  $request['type'] = "getTournament";
}
else
{
  $request['type'] = "showTournaments";
}
//$request['type'] = $_POST["requestType"];
//$request['username'] = $_POST["uname"];
//$request['password'] = $_POST["pword"];

//$request['username'] = "Howard";
//$request['password'] = "sing";

//echo "              request uname " . $request['username'] . PHP_EOL;
//echo "              request pword " . $request['password'] . PHP_EOL;


$request['message'] = $msg;
$response = $client->send_request($request);
$response = json_encode($response, JSON_FORCE_OBJECT);
//$response = $client->publish($request);

//echo "client received response: " . PHP_EOL;
print($response);
//echo "\n\n";

//echo $argv[0]." END".PHP_EOL;
?>
