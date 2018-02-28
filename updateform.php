<?php
    ini_set('display_errors', '1');
    mysql_connect ("sql2.njit.edu", "jj246", "IycEcu0Cv") or die("Could not connect: " . mysql_error());
    $db = mysql_select_db ("jj246") or die("No database.");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['patientName'];
        $id = $_POST['patientId']; 
        $email = $_POST['patientEmail']; 
        $action = $_POST['pAction'];
        if ($action == 'records')
        {
            header("location:print.php");
        }
        elseif ($action == 'appointment')
        {
            header("location:appointments.php");
        }
    }
?>