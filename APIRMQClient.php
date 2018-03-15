
<?php
//thisgoesupthere^^ #!/usr/bin/php
//echo "argv 1:  ". $argv[1]. PHP_EOL;
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//echo "we are about to connect" . PHP_EOL;

$client = new rabbitMQClient("APIRMQ.ini", "testServer");

//echo "we made client" . PHP_EOL;
//echo $argv[1]. PHP_EOL;

if (isset($argv[1]))
{
  $msg = $argv[1];
  //echo "argv 1:  ". $argv[1]. PHP_EOL;
  //echo "msg:  " . $msg. PHP_EOL;
}
else
{
  $msg = "test message";
}

//echo "msg:  " . $msg. PHP_EOL;
$request = array();
$request['type'] = "getRank";
//$request['type'] = $_POST["requestType"];
$request['summonername'] = $argv[1];
//$request['password'] = $_POST["pword"];

//$request['username'] = "Howard";
//$request['password'] = "sing";

//echo "              request uname " . $request['username'] . PHP_EOL;
//echo "              request pword " . $request['password'] . PHP_EOL;


$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

//echo "client received response: " . PHP_EOL;
//echo $response .PHP_EOL;
return $response;
//echo "\n\n";

//echo $argv[0]." END".PHP_EOL;
?>
