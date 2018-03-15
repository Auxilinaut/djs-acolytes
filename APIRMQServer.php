#!/usr/bin/php
<?php
  require_once('path.inc');
  require_once('get_host_info.inc');
  require_once('rabbitMQLib.inc');

  //$sessionid = NULL;
  echo "running server" . PHP_EOL;
  $sessionid = NULL;

  function getrank($summoner)
  {
    $key = "RGAPI-9efc7ea3-21e1-43a3-a421-0c89d90c4052"; 
    $url = "https://na1.api.riotgames.com/lol/summoner/v3/summoners/by-name/".$summoner."?api_key=" . $key;

    //echo $url;
    //echo "https://na1.api.riotgames.com/lol/summoner/v3/summoners/by-name/nizzy2k11?api_key=RGAPI-c349753d-e8e3-42c4-97dd-46ccd353c99a" + PHP_EOL;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_VERBOSE, False);

    $result = curl_exec($ch);
    //echo $ch;
    //echo gettype($result). PHP_EOL;
    //echo $result. PHP_EOL;
    $myJSON = json_decode($result);
    //$temp = $myJSON->accoutId;
    echo $myJSON->id . PHP_EOL;
 
    curl_close($ch);
    $url = "https://na1.api.riotgames.com/lol/league/v3/positions/by-summoner/". $myJSON->id . "?api_key=". $key;
    $ch = curl_init($url);
    //echo $url. PHP_EOL;
    //curl_setopt($ch, CURLOPT_URL, $url);
  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_VERBOSE, False);

    $result = curl_exec($ch);

    //echo gettype($result) . PHP_EOL;
    //echo $result. PHP_EOL;

    $myJSON = json_decode($result);
    //echo $myJSON[0]->queueType;

    curl_close($ch);
    //echo $myJSON[0]->tier.$myJSON[0]->rank;
    //output
    echo $myJSON[0]->tier.$myJSON[0]->rank . PHP_EOL;
    return $myJSON[0]->tier.$myJSON[0]->rank;
    //echo $myJSON[0]->tier;
    //echo $myJSON[0]->rank. PHP_EOL;

    
  }

  function requestProcessor($request)
  {
    echo "received request" . PHP_EOL;
    //echo "summoner name: ". $request['summonername'];
    //var_dump($request);
    if(!isset($request['type']))
    {
      return "ERROR: request type not set";
    }
    switch ($request['type'])
    {
	case "getRank":
		//echo "Rank:  ".getRank($request['summonername'].PHP_EOL);
		return getRank($request['summonername']);
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

