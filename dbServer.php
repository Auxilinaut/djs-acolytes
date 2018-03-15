#!/usr/bin/php
<?php
  require_once('path.inc');
  require_once('get_host_info.inc');
  require_once('rabbitMQLib.inc');

	echo "running server" . PHP_EOL;
	
	$dbhost = "localhost";

  function login($username, $password)
  {
    echo "trying to connect to mysql server" . PHP_EOL;
    $con = mysqli_connect ($GLOBALS['dbhost'], "root", "Password12345", "userdata");// or die("Could not connect: " . mysql_error());
    
    // Check connection
    if (mysqli_connect_errno())
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
		}
		
		$sessionid;
		$logintime;
    // $db = mysql_select_db ("root") or die("No database.");
    //session_start();

    // lookup username in databas
    // check password
    
    //echo "query consists of username " . $username . " and password " . $password . PHP_EOL;
    $selectquery = "SELECT * FROM logininfo WHERE username = '$username' and pword = '$password'";
    
    if ($logininfo = mysqli_query($con, $selectquery))
    {
		//session_start();
		$person = mysqli_fetch_array($logininfo, MYSQLI_ASSOC);
		
		$sessionid = hash("sha256", $person['id'] . time());  // Initializing Session with value of PHP Variable

		$logintime = time();

		$updatequery = "UPDATE logininfo SET sessionid = '$sessionid', epochtime = '$logintime' WHERE username = '$username' and pword = '$password'";
		
		if ($con->query($updatequery) === TRUE) {
			echo "Updated sessionid/logintime successfully"; //(HEADER TO TOURNEY LOC)
		} else {
			echo "Error in updating sessionid/logintime: " . $con->error;
		}

		$con->close();
		
		return $sessionid;
    }
    else
    {
      echo "no user with that info";
      return 0;
	}
  }

  function register($username, $password, $email, $ingamename)
  {
		echo "trying to connect to mysql server" . PHP_EOL;
		$con = mysqli_connect ($GLOBALS['dbhost'], "root", "Password12345", "userdata");// or die("Could not connect: " . mysql_error());

		// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
		}
		// $db = mysql_select_db ("root") or die("No database.");
		//session_start();
		echo "this should be an ingamename: ". $ingamename . PHP_EOL;

		//echo "query consists of username " . $username . " and password " . $password . PHP_EOL;
		$mmr = exec ('php APIRMQClient.php '. $ingamename);
		
		$query = "INSERT INTO logininfo (username, pword, email, ingamename) VALUES ('$username', '$password', '$email', '$ingamename')";

		if ($con->query($query) === TRUE)
		{
			//session_start();
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			//$GLOBALS['sessionid'] = $row["id"];  // Initializing Session with value of PHP Variable
			//echo "sessionid: " . $GLOBALS['sessionid'] . PHP_EOL;

			$query = "INSERT INTO playerinfo (username, ign, mmr) VALUES ('$username', '$ingamename', '$mmr')";

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
				echo "could not register";
				return false;
			}
		}
		else
		{
			echo "no sessionid";
			return false;
		}

		
  }

  function tournaments()
  {
		$con = mysqli_connect ($GLOBALS['dbhost'], "root", "Password12345", "userdata");

		// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
		}
		
		$query = "SELECT * FROM tournamentinfo";

		if ($result = mysqli_query($con, $query))
		{
			$resArray = array();
			//session_start();
			//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			
			/* fetch associative array */
			while ($row = $result->fetch_assoc()) {
				array_push($resArray, array($row['tournamentname'], $row['hostname'], $row['startTimeEpoch']));
			}
			
			echo "tournamentinfo: " . PHP_EOL;
			//var_dump($resArray);

			// Initializing Session with value of PHP Variable
			//echo "sessionid: " . $GLOBALS['sessionid'] . PHP_EOL;
			return $resArray;
		}
		else
		{
			echo "no tournament results";
			return NULL;
		}
	}
	
function validate($sessionid)
{
	$query = "SELECT epochtime FROM logininfo WHERE sessionid = ". $sessionid;
	$con = mysqli_connect ($GLOBALS['dbhost'], "root", "Password12345", "userdata");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
	}
	if ($result = mysqli_query($con, $query))
	{

		if( (time() - $result) > 600)
		{
			return false;		
		}
		else
		{
			$query = "UPDATE logininfo SET epochtime = ". time() . " WHERE sessionid = ". $sessionid;
			$con = mysqli_connect ($GLOBALS['dbhost'], "root", "Password12345", "userdata");
			if (mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
			}
			if ($result = mysqli_query($con, $query))
			{
				return true;
			}
			else
		  	{
				echo "Session not found";
		  		return NULL;
		  	}
		}
  	}
  	else
  	{
		echo "Session not found";
  		return NULL;
  	}
  }

  function getTournament($id)
  {
		$query = "SELECT * FROM tournamentinfo WHERE tournamentid = ". $id;

		$con = mysqli_connect ($GLOBALS['dbhost'], "root", "Password12345", "userdata");
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
		}


		if ($result = mysqli_query($con, $query))
		{
			$resArray = array();
			//session_start();
			//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			
			/* fetch associative array */
			while ($row = $result->fetch_assoc()) {
				array_push($resArray, array($row['tournamentname'], $row['hostname'], $row['startTimeEpoch']));
			}
			
			echo "tournamentinfo: " . PHP_EOL;

			var_dump($resArray);

			// Initializing Session with value of PHP Variable
			//echo "sessionid: " . $GLOBALS['sessionid'] . PHP_EOL;
			return $resArray;
		}
		else
		{
			echo "no tournament results";
			return NULL;
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
				return login($request['username'], $request['password']);
				break;
			case "register":
				register($request['username'], $request['password'], $request['email'], $request['ingamename']);
				break;
			case "showTournaments":
				return tournaments();
				break;
			case "getTournament":
				return getTournament();
				break;
			case "createTournament":
				createTournament($request['tname'], $request['tdate'], $request['tdesc']);
				break;
			case "viewProfile":
				viewProfile($request['username']);
				break;
			case "updateProfile":
				updateProfile($request['email'], $request['username'], $request['password'], $request['ingamename'], $request['preftop'], $request['prefjungle'], $request['prefmid'], $request['prefadc'], $request['prefsupport']);
				break;ss
			case "validateSession":
				validate($request['sessionid']);
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

