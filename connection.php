<?php
/*
    $objConnect = mysql_connect("localhost","root","ubuntu");// or die("Could not connect: " . mysql_error()); 
    mysql_select_db("userdata", $objConnect);

  // Check connection
    if (mysqli_connect_errno())
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error() . PHP_EOL;
    }
*/

$mysqli = new mysqli("localhost", "root", "ubuntu", "userdata");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $mysqli->host_info . "\n";

$mysqli = new mysqli("127.0.0.1", "root", "ubuntu", "userdata", 3306);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

echo $mysqli->host_info . "\n";

?>

