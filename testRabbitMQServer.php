#!/usr/bin/php
<?php
  require_once('path.inc');
  require_once('get_host_info.inc');
  require_once('rabbitMQLib.inc');

  echo "running server" . PHP_EOL;
  $sessionid = NULL;
  $tournaments = NULL;

  function doLogin($username, $password)
  {
    echo "trying to connect to mysql server" . PHP_EOL;
    $con = mysqli_connect ("localhost", "root", "Password12345", "userdata");// or die("Could not connect: " . mysql_error());
    
    // Check connection
    if (mysqli_connect_errno())
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
    }
    // $db = mysql_select_db ("root") or die("No database.");
    //session_start();

    // lookup username in databas
    // check password
    
    //echo "query consists of username " . $username . " and password " . $password . PHP_EOL;
    $query = "SELECT * FROM logininfo WHERE username = '$username' and pword = '$password'";
    
    if ($result = mysqli_query($con, $query))
    {
      //session_start();
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $GLOBALS['sessionid'] = $row['sessionid'];  // Initializing Session with value of PHP Variable
      echo "sessionid: " . $GLOBALS['sessionid'] . PHP_EOL;
      return true;
    }
    else
    {
      echo "no sessionid";
      return false;
    }
  }

  function register($email, $username, $password)
  {
	echo "trying to connect to mysql server" . PHP_EOL;
	$con = mysqli_connect ("localhost", "root", "Password12345", "userdata");// or die("Could not connect: " . mysql_error());

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
	}
	// $db = mysql_select_db ("root") or die("No database.");
	//session_start();

	// lookup username in databas
	// check password

	//echo "query consists of username " . $username . " and password " . $password . PHP_EOL;
	$query = "UPDATE logininfo WHERE username = '$username' and pword = '$password'";

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

  function tournaments()
  {
	$GLOBALS['tournaments'] = array();

	$con = mysqli_connect ("localhost", "root", "Password12345", "userdata");

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
	}
	
	$query = "SELECT * FROM tournamentinfo";

	if ($result = mysqli_query($con, $query))
	{
		//session_start();
		//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		/* fetch associative array */
		while ($row = $result->fetch_assoc()) {
			array_push($GLOBALS['tournaments'], array($row['tournamentname'], $row['hostname'], $row['startTimeEpoch']));
		}
		
		echo "tournamentinfo: " . PHP_EOL;
		var_dump($GLOBALS['tournaments']);

		// Initializing Session with value of PHP Variable
		//echo "sessionid: " . $GLOBALS['sessionid'] . PHP_EOL;
		return true;
	}
	else
	{
		echo "no tournament results";
		return false;
	}
  }

  function requestProcessor($request)
  {
    echo "received request" . PHP_EOL;
    //var_dump($request);
    if(!isset($request['type']))
    {
      return "ERROR: request type not set";
    }
    switch ($request['type'])
    {
	case "login":
        	doLogin($request['username'], $request['password']);
		if (isset($GLOBALS['sessionid']))
		    {
		      return array("returnCode" => '0', 'sessionid' => ''. $GLOBALS['sessionid'] .'');
		    }
		    else
		    {
		      return array("returnCode" => '1', 'sessionid' => '0');
		    }
	break;
	case "register":
        	register($request['email'], $request['username'], $request['password']);
        break;
	case "showTournaments":
        	tournaments();
		return $GLOBALS['tournaments'];
        break;
	case "createTournament":
        	createTournament($request['tname'], $request['tdate'], $request['tdesc']);
        break;
	case "viewProfile":
        	viewProfile($request['username']);
        break;
	case "updateProfile":
		updateProfile($request['email'], $request['username'], $request['password'], $request['ingamename'], $request['preftop'], $request['prefjungle'], $request['prefmid'], $request['prefadc'], $request['prefsupport']);
	break;
	case "validateSession":
        	doValidate($request['sessionid']);
        break;
	default:
        	echo "ERROR: request type unhandled";
        break;
    }

  }

  $server = new rabbitMQServer("testRabbitMQ.ini", "testServer");

  $server->process_requests('requestProcessor');
  exit();
?>

