<html>
<head>
</head>
<body>
    <h1>Patient Records</h1>

    <?php
    session_start();
    mysql_connect('sql2.njit.edu','jj246','IycEcu0Cv') or
        die("Could not connect: " . mysql_error());
    mysql_select_db("jj246");
    if(isset($_SESSION['ID']))
    {
        $pid = $_SESSION['ID'];
    }
    else
    {
        echo "<p>Error: Need ID</p>";
    }
    $result = mysql_query("Select r.APPOINTMENTID AS RECORDID, p.NAME AS PATIENTNAME, r.HEIGHT, r.WEIGHT, r.BMI, r.BLOODPRESSURE, r.VISITREASON, r.DIAGNOSIS, a.DATE, d.NAME AS DOCTORNAME from IT202A3RECORDS r
    Join IT202A3APPOINTMENTS a on a.ID = r.APPOINTMENTID
    Join IT202A3PATIENTS p on p.ID = r.PATIENTID
    Join IT202A3DOCTORS d on d.ID = a.DOCTORID
    WHERE p.ID = $pid");
    ?>

    <table>
    <tr>
        <td>APPT</td>
        <td>DATE</td>
        <td>PATIENT</td>
        <td>HEIGHT</td>
        <td>WEIGHT</td>
        <td>BMI</td>
        <td>BLOODPRESSURE</td>
        <td>VISITREASON</td>
        <td>DIAGNOSIS</td>
        <td>DOCTOR</td>
    </tr>

    <?php
    while ($row = mysql_fetch_array($result)) {
        echo "<tr>";
        echo "<td>".$row[RECORDID]."</td>";
        echo "<td>".$row[DATE]."</td>";
        echo "<td>".$row[PATIENTNAME]."</td>";
        echo "<td>".$row[HEIGHT]."</td>";
        echo "<td>".$row[WEIGHT]."</td>";
        echo "<td>".$row[BMI]."</td>";
        echo "<td>".$row[BLOODPRESSURE]."</td>";
        echo "<td>".$row[VISITREASON]."</td>";
        echo "<td>".$row[DIAGNOSIS]."</td>";
        echo "<td>".$row[DOCTORNAME]."</td>";
        echo "</tr>";
    }
    mysql_free_result($result);
    ?>
    </table>
</body>
</html>