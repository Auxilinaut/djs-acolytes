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
            <div id="upcoming" class="col-xs-12">
		
	    </div>
        </div>
        <!--<video autoplay loop id="video-background" muted><source src="" type="video/mp4"></video>-->
    </div>
    <script>
        var http = new XMLHttpRequest();

	    window.onload = submitRequest;

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
                var upcoming = document.getElementById("upcoming");
                upcoming.innerHTML = res;
                var data = JSON.parse(res);
                var tourneyCount = length(data.tournaments);
                console.dir(data);
                for (var i = 0; i < tourneyCount; i++)
                {
                    $("<p>Test</p>").appendTo(".upcoming");
                }
            }
            else
            {
                var upcoming = document.getElementById("upcoming");
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
