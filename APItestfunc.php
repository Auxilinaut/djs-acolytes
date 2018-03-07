<?php
//input
$summoner = "nizzy2k11";


$key = "RGAPI-c349753d-e8e3-42c4-97dd-46ccd353c99a";
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
//echo $myJSON->id . PHP_EOL;

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


//output
echo $myJSON[0]->tier;
echo $myJSON[0]->rank. PHP_EOL;

curl_close($ch);

?>
