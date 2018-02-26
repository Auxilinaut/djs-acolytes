#!/usr/bin/php
<?php
  include("vendor/autoload.php");
  include("connections/mysqlconnection.php"); 
  require_once('path.inc');
  require_once('get_host_info.inc');
  require_once('rabbitMQLib.inc');

  echo "running server" . PHP_EOL;
  $sessionid = NULL;

   function doLogin($username, $password)
  {
    echo "trying to connect to mysql server" . PHP_EOL;
    echo "query consists of username " . $username . " and password " . $password . PHP_EOL;
    $query = "SELECT * FROM logininfo WHERE username = '$username' and pword = '$password'";
    
    if ($result = mysqli_query($con, $query))
    {
      //session_start();
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $GLOBALS['sessionid'] = $row["id"];  // Initializing Session with value of PHP Variable
      echo "sessionid: " . $GLOBALS['sessionid'] . PHP_EOL;
      return true;
    }
    else
    {
      echo "no sessionid";
      return false;
    }
  }

  function requestProcessor($request)
  {
    echo "received request" . PHP_EOL;
    var_dump($request);
    if(!isset($request['type']))
    {
      return "ERROR: request type not set";
    }
    switch ($request['type'])
    {
      case "login":
        doLogin($request['username'], $request['password']);
        break;
      case "validate_session":
        doValidate($request['sessionid']);
        break;
      default:
        echo "ERROR: request type unhandled";
        break;
    }

    if (isset($GLOBALS['sessionid']))
    {
      return array("returnCode" => '0', 'sessionid' => ''. $GLOBALS['sessionid'] .'');
    }
    else
    {
      return array("returnCode" => '1', 'sessionid' => '0');
    }
  }


  $server = new rabbitMQServer("testRabbitMQ.ini", "djs-acolytes");

  $server->process_requests('requestProcessor');
  exit();
?>

