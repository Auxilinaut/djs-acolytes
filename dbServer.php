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

    // lookup username in databas
    // check password
    
    $selectquery = "SELECT * FROM logininfo WHERE username = '$username' and pword = '$password'";
    
    if ($logininfo = mysqli_query($con, $selectquery))
    {
		//session_start();
		$person = mysqli_fetch_array($logininfo, MYSQLI_ASSOC);

		echo $person['id'] . PHP_EOL;
		if (!isset($person['id']))
		{
			echo "lessthanzeroid" . PHP_EOL;
			return 0;

		}
		
		$sessionid = hash("sha256", $person['id'] . time());  // Initializing Session with value of PHP Variable

		$logintime = time();

		$updatequery = "UPDATE logininfo SET sessionid = '$sessionid', epochtime = '$logintime' WHERE username = '$username' and pword = '$password'";
		
		if ($con->query($updatequery) === TRUE) {
			echo "Updated sessionid/logintime successfully"; //(HEADER TO TOURNEY LOC)
			$con->close();
			return $sessionid;
		} else {
			echo "Error in updating sessionid/logintime: " . $con->error;
			return 0;
		}
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
		
		echo "ingamename: ". $ingamename . PHP_EOL;

		$mmr = exec ('php APIRMQClient.php '. $ingamename);
		
		$query = "INSERT INTO logininfo (username, pword, email, ingamename) VALUES ('$username', '$password', '$email', '$ingamename')";

		if ($con->query($query) === TRUE)
		{
			echo "inserted into logininfo";

			$query = "INSERT INTO playerinfo (username, ign, mmr) VALUES ('$username', '$ingamename', '$mmr')";

			if ($con->query($query) === TRUE)
			{
				echo "inserted into playerinfo";

				$selectquery = "SELECT * FROM logininfo WHERE username = '$username'";
    
				if ($logininfo = mysqli_query($con, $selectquery))
				{
					$person = mysqli_fetch_array($logininfo, MYSQLI_ASSOC);
					
					$sessionid = hash("sha256", $person['id'] . time());  // Initializing Session with value of PHP Variable

					$logintime = time();

					$updatequery = "UPDATE logininfo SET sessionid = '$sessionid', epochtime = '$logintime' WHERE username = '$username' and pword = '$password'";
			
					if ($con->query($updatequery) === TRUE) {
						echo "Updated sessionid/logintime successfully";
						$con->close();
						return $sessionid;
					} else {
						echo "Error in updating sessionid/logintime: " . $con->error;
						$con->close();
						return 0;
					}
				}
				else
				{
					echo "could not select person from logininfo: " . $con->error;
					$con->close();
					return 0;
				}
			}
			else
			{
				echo "unable to insert into playerinfo: " . $con->error;
				$con->close();
				return 0;
			}
		}
		else
		{
			echo "unable to insert into logininfo: " . $con->error;
			$con->close();
			return 0;
		}

		
  }

	function createTournament($tname, $tdate, $tdesc, $sessionid)
	{
		echo "trying to connect to mysql server" . PHP_EOL;
		$con = mysqli_connect ($GLOBALS['dbhost'], "root", "Password12345", "userdata");// or die("Could not connect: " . mysql_error());
		echo "tdate is: " . $tdate . PHP_EOL;
		// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
		}

		$selectquery = "SELECT * FROM logininfo WHERE sessionid = '$sessionid'";
    
		if ($logininfo = mysqli_query($con, $selectquery))
		{
			//session_start();
			$person = mysqli_fetch_array($logininfo, MYSQLI_ASSOC);
			
			$player = $person['username'];  // Initializing Session with value of PHP Variable
		
			$query = "INSERT INTO tournamentinfo (tournamentname, startTimeEpoch, `description`, hostname) VALUES ('$tname', $tdate, '$tdesc', '$player')";

			if ($con->query($query) === TRUE)
			{
				echo "inserted into tournamentinfo";

				$last_id = $con->insert_id;
				echo "new tournament id: " . $last_id . PHP_EOL;
				$con->close();
				return $last_id;
			}
			else
			{
				echo "unable to insert into tournamentinfo: " . $con->error;
				$con->close();
				return 0;
			}
		}
		else
		{
			echo "unable to select from logininfo: " . $con->error;
			$con->close();
			return 0;
		}
	}

	function tournament($tid)
	{
		
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
			
			/* fetch associative array */
			while ($row = $result->fetch_assoc()) {
				array_push($resArray, array("tname" => $row['tournamentname'], "tdesc" => $row['description'], "starttime" => $row['startTimeEpoch']));
			}
			
			echo "tournamentinfo: " . PHP_EOL;
			var_dump($resArray);

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
					return false;
				}
			}
		}
		else
		{
			echo "Session not found";
			return false;
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
		
		/* fetch associative array */
		while ($row = $result->fetch_assoc()) {
			array_push($resArray, array($row['tournamentname'], $row['hostname'], $row['startTimeEpoch']));
		}
		
		echo "tournamentinfo: " . PHP_EOL;

		var_dump($resArray);

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
    var_dump($request);
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
			return register($request['username'], $request['password'], $request['email'], $request['ingamename']);
			break;
		case "showTournaments":
			if (isset($request['tid']))
				return tournament($request['tid']);
			else
				return tournaments();
			break;
		case "getTournament":
			return getTournament($request['id']);
			break;
		case "createTournament":
			createTournament($request['tname'], $request['tdate'], $request['tdesc'], $request['sessionid']);
			break;
		case "viewProfile":
			viewProfile($request['username']);
			break;
		case "updateProfile":
			updateProfile($request['email'], $request['username'], $request['password'], $request['ingamename'], $request['preftop'], $request['prefjungle'], $request['prefmid'], $request['prefadc'], $request['prefsupport']);
			break;
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

