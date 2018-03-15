<?php
  require_once('path.inc');
  require_once('get_host_info.inc');
  require_once('rabbitMQLib.inc');

  echo "running server" . PHP_EOL;
  function logError($errorType, $errorMsg, $errorId)
  {
	echo $errorType	. PHP_EOL;
	echo $errorMsg 	. PHP_EOL;
	echo $errorId 	. PHP_EOL;
	$errorMsg = $errorType . ' ' . $errorMsg . ' ' . $errorId . ' ' ;	
	echo $errorMsg;


	switch ($errorType)
	{
		case"API":
			$file = 'Logs/APIlogs.txt';
			break;
		default:
        		$file = 'Logs/logs.txt';
     			break;
	}


	$errorFile = file_put_contents($file, $errorMsg . PHP_EOL, FILE_APPEND | LOCK_EX);

	return "it worked take that";
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
	case "error":
		return logError($request['errorType'], $request['errorMsg'], $request['errorId']);
		break;
	default:
        	echo "ERROR: request type unhandled";
        break;
    }

  }

  $server = new rabbitMQServer("errorRMQ.ini", "testServer");

  $server->process_requests('requestProcessor');
  exit();
?>

