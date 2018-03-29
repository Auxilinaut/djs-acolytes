<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tournaments</title>
    <link href="index.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <?php include 'navbar.php';?>
    <div class="container">
        <h1>Tournaments</h1>
        <div class="row">
            <div id="results" class="col-xs-12">
		
	        </div>
        </div>
    </div>
    <script>
        var http = new XMLHttpRequest();

        <?php
            if (isset($_GET['id']))
            {
                echo "<script type='text/javascript'>window.onload = singleTournamentRequest;</script>";
            }
            else
            {
                echo "<script type='text/javascript'>window.onload = submitRequest;</script>";
            }
        ?>

	var url = new URL(window.location.href);
	var id = url.searchParams.get("id");
	console.log(id);

	if(id != null)
		singleTournamentRequest(id);
	else
		submitRequest();

        function singleTournamentRequest(tid)
        {
            http.open("POST", "tournamentsClient.php", false);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = singleTournamentResponse;
            http.send("tid=" + tid);
        }

        function singleTournamentResponse()
        {
            if (http.readyState == 4)
            {
                var res = http.responseText;
                var upcoming = document.getElementById("results");
                upcoming.innerHTML = res;
                var data = JSON.parse(res);
                var tourneyCount = data.tournaments.length;
                console.dir(data);
                for (var i = 0; i < tourneyCount; i++)
                {
                    var obj = data.tournaments[i];
                    for (var key in obj){
                        var attrName = key;
                        var attrValue = obj[key];
                        $(attrName + ": " + attrValue).appendTo("#results");
                    }
                }
            }
            else
            {
                var upcoming = document.getElementById("results");
                upcoming.innerHTML = "readystate not 4: " + http.readyState;
            }
        }

        function submitRequest()
        {
            http.open("POST", "tournamentsClient.php", false);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = receiveResponse;
            http.send(null);
        }

        function receiveResponse()
        {
            if (http.readyState == 4)
            {
                var res = http.responseText;
                var upcoming = document.getElementById("results");
                upcoming.innerHTML = res;
                var data = JSON.parse(res);
                var tourneyCount = length(data.tournaments);
                console.dir(data);
                for (var i = 0; i < tourneyCount; i++)
                {
                    var obj = data.tournaments[i];
                    for (var key in obj){
                        var attrName = key;
                        var attrValue = obj[key];
                        $(attrName + ": " + attrValue).appendTo("#results");
                    }
                }
            }
            else
            {
                var upcoming = document.getElementById("results");
                upcoming.innerHTML = "readystate not 4: " + http.readyState;
            }
        }

        function length(obj)
        {
            return Object.keys(obj).length;
        }

    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
