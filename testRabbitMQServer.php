#!/usr/bin/php
<?php
  require_once('path.inc');
  require_once('get_host_info.inc');
  require_once('rabbitMQLib.inc');

  function doLogin($username, $password)
  {
    $con = mysqli_connect ("localhost", "root", "", "userdata");// or die("Could not connect: " . mysql_error());
    
    // Check connection
    if (mysqli_connect_errno())
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    // $db = mysql_select_db ("root") or die("No database.");
    //session_start();

    // lookup username in databas
    // check password
    
    $query = "SELECT * FROM logininfo WHERE username = '$username' and pword = '$password'";
    
    if ($result = mysqli_query($con, $query))
    {
      //session_start();
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $sessionid = $row["id"];  // Initializing Session with value of PHP Variable
      return true;
    }
    else
    {
      return false;
    }
  }

  function requestProcessor($request)
  {
    echo "received request" . PHP_EOL;
    var_dump($request);
    if(!isset($request['type']))
    {
      return "ERROR: unsupported message type";
    }
    switch ($request['type'])
    {
      case "login":
        return doLogin($request['username'], $request['password']);
      case "validate_session":
        return doValidate($request['sessionid']);
    }

    if (isset($sessionid))
      return array("returnCode" => '0', 'sessionid' => ''.$sessionid.'');
    else
      return array("returnCode" => '1', 'sessionid' => '0');
  }

  $server = new rabbitMQServer("testRabbitMQ.ini", "testServer");

  $server->process_requests('requestProcessor');
  exit();
?>

