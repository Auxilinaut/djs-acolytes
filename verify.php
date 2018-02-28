<?php
mysql_connect ("sql2.njit.edu", "jj246", "IycEcu0Cv") or die("Could not connect: " . mysql_error());
$db = mysql_select_db ("jj246") or die("No database.");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
   // username and password sent from form 
   
   $u = $_POST['username'];
   $p = $_POST['pass']; 
   
   $query = "SELECT ID FROM IT202A4USERS WHERE USERNAME = '$u' and PASS = '$p'";
   $result = mysql_query($query);
   
   $count = mysql_num_rows($result);
     
   if($count == 1) {
        session_start();
        $row = mysql_fetch_array($result);
        $_SESSION['ID']= $row[ID];  // Initializing Session with value of PHP Variable
        header("location:update.php");
   }else {
        header("location:index.html");
   }
}
?>