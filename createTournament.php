<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Create Your Tournament</title>
    <link rel="stylesheet" href="index.css" type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <script>
        if (localStorage.getItem("sessionid") == null) {
            var url = 'index.php';
            window.location.href = url;
        }
    </script>

<?php include 'navbar.php';?>

   <div class="container">

    <div id="login-form">
        <form autocomplete="off">

            <div class="col-md-12">

                <div class="form-group">
                    <h1>Tournament Creation</h1>
                </div>

                <div class="form-group">
                    <hr/>
                </div>

                     <?php
                if (isset($errMSG)) {

                    ?>
                    <div class="form-group">
                        <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                            <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                  
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            Name of your Tournament: <br>
                            <input type="text" id="tname" name="tournamentname" class="form-control" placeholder="Tournament Name" required/>
                        </div>
                    </div>
		    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>			     Description for tournament: <br>	
                            <input type="text" id="tdesc" name="description" class="form-control" placeholder="Description" required/>
                        </div>
                    </div>	
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            Time your tourney will begin: <br>
                            <input id="tdate" type="date" required/>
                            <input id="ttime" type="time" required/>
                        </div>
                    </div>
                    
            
                    <div class="form-group">
                        <button type="button" class="btn btn-block btn-primary" onclick="registerCli()" name="signup" id="reg">Create</button>
                    </div>

                    <div class="form-group">
                        <hr/>
                    </div>

            </form>
            <div id="response">
                
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>
        var http = new XMLHttpRequest();

        function registerCli()
        {
            var tourname = document.getElementById("tname").value;
            var desc = document.getElementById("tdesc").value;
            var time = document.getElementById("tdate").value;
            var sessionid = localStorage.getItem("sessionid");

	    var startDate = $('#tdate').val();
  	    var startTime = $('#ttime').val();
  	    var date = new Date(startDate + ' ' + startTime);
  	    //console.log(date)

            http.open("POST", "createTournamentClient.php", false);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = receiveResponse;
            http.send("tname=" + tourname + "&tdesc=" + desc + "&tdate=" + date.getTime() + "&sessionid=" + sessionid);
        }

        function receiveResponse()
        {
            if (http.readyState == 4)
            {
                var res = http.responseText;
                var response = document.getElementById("response");
                response.innerHTML = res;
                //var data = JSON.parse(res);
                console.log("tid: " + res);
                var url = 'tournaments.php?id=' + res;
                window.location.href = url;
            }
            else
            {
                var testresponse = document.getElementById("testresponse");
                testresponse.innerHTML = "readystate not 4: " + http.readyState;
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>


