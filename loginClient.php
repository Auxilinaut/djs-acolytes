
<?php
//thisgoesupthere^^ #!/usr/bin/php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//echo "we are about to connect" . PHP_EOL;

$client = new rabbitMQClient("loginRabbitMQ.ini", "testServer");

//echo "we made client" . PHP_EOL;

if (isset($argv[1]))
{
  $msg = $argv[1];
}/*
else
{
  $msg = "test message";
}*/

$request = array();
$request['type'] = "login";
//$request['type'] = $_POST["requestType"];
$request['username'] = $_POST["uname"];
$request['password'] = $_POST["pword"];

//$request['username'] = "Howard";
//$request['password'] = "sing";

//echo "              request uname " . $request['username'] . PHP_EOL;
//echo "              request pword " . $request['password'] . PHP_EOL;

if (isset($msg))
{
  $request['message'] = $msg;
}

$sessionid = $client->send_request($request);
//$response = $client->publish($request);
$_SESSION['sessionid'] = $sessionid;
//exec('errorClient.php', 'client received response: ' . PHP_EOL);
print "sessionid: " . $_SESSION['sessionid'] . PHP_EOL;
/*if ($sessionid != "0")
{
  //header('Location:tournaments.php');
  print "<a href='tournaments.php'>Continue</a>" . PHP_EOL;
}
else
{
  print "No user found with that username and password" . PHP_EOL;
}*/
//echo "\n\n";

//echo $argv[0]." END".PHP_EOL;
?>
