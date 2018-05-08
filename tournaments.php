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
        <div id="results">
		
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>
        var http = new XMLHttpRequest();
	
	var query = getQueryParams(document.location.search);
	var id = query.id;
	console.log(id);

	if(id != null)
		singleTournamentRequest(id);
	else
		submitRequest();
	
	//show 1 tournament
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
		/*var query = getQueryParams(document.location.search);
		var id = query.id;
		console.log(id);*/
		var res = http.responseText;
		var data = JSON.parse(res);
		var obj = data[0];
		var appending;
		//console.log("tourney " + i + ":");
		console.dir(obj);

		appending = "<div class='row'>";

		Object.keys(obj).forEach(function(key) {
			if (key == "tname")
			{
				appending += "<div class='col'>" + obj[key] + "</div>";
			}
			else if (key == "tdesc")
			{
				appending += "<div class='col'>" + obj[key] + "</div>";
			}
			else if (key == "starttime")
			{	
				var date = new Date(+obj[key]);
				var year = date.getFullYear();
				var month = date.getMonth() + 1;
				var day = date.getDate();
				var hours = date.getHours();
				var minutes = date.getMinutes();

				appending += "<div class='col'>" + 
					month + "/" + day + "/" + year + " @ " + hours +
					":" + minutes + "</div>";
			}
		});
		    
		appending += "</div>";

		$( "#results" ).append(appending);
            }
            else
            {
                var upcoming = document.getElementById("results");
                upcoming.innerHTML = "readystate not 4: " + http.readyState;
            }
        }
	
	//show all tournaments
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
                var data = JSON.parse(res);
                var tourneyCount = length(data);
		var appending;
                console.dir(data);
                for (var i = 0; i < tourneyCount; i++)
                {
                    var obj = data[i];
		    console.log("tourney " + i + ": " + data[i]);

		    appending = "<div class='row'>";

		    Object.keys(obj).forEach(function(key) {
			if (key == "tname")
			{
				appending += "<div class='col'><a href='tournaments.php?id=" + (+i+1) + "'>" + obj[key] + "</a></div>";
			}
			else if (key == "tdesc")
			{
				appending += "<div class='col'>" + obj[key] + "</div>";
			}
			else if (key == "starttime")
			{	
				var date = new Date(+obj[key]);
				var year = date.getFullYear();
				var month = date.getMonth() + 1;
				var day = date.getDate();
				var hours = date.getHours();
				var minutes = date.getMinutes();

				appending += "<div class='col'>" + 
					month + "/" + day + "/" + year + " @ " + hours +
					":" + minutes + "</div>";
			}
		    });
		    
		    appending += "</div>";

		    $( "#results" ).append(appending);
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

	function getQueryParams(qs) {
		qs = qs.split('+').join(' ');

		var params = {}, tokens, re = /[?&]?([^=]+)=([^&]*)/g;

		while (tokens = re.exec(qs)) {
			params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
		}

		return params;
	}
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
