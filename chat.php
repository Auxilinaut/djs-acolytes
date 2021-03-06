<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Forum</title>
    <link rel="stylesheet" href="chat.css" type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    
</head>
 <?php include 'navbar.php';?>

<br/>
<br/>
<br/>

<div id="wrapper">
    <div id="menu">
        <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
        <div style="clear:both"></div>
    </div>

<div align="center">
    <div id="chatbox"></div>

    <form name="message" action="">
        <input name="id" type="text" id="txt" size="63" />
        <input name="id" type="button" onclick="submitRequest()"  id="submitmsg" size="63" value="Send" />
    </form>



</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
 
});
</script>
<script>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        var http = new XMLHttpRequest();
	var query = getQueryParams(document.location.search);

        function submitRequest()
        {
            var txt = document.getElementById("txt").value;
            var sid = localStorage.getItem ("sessionid").value;

            http.open("POST", "chatSend.php", false);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = receiveResponse;
            http.send("txt=" + txt + "&sid=" + sid + "&tournamentid=" + query.id);
        }

        function receiveResponse()
        {
            if (http.readyState == 4)
            {
                var res = http.responseText;
                var response = document.getElementById("response");
                //var data = JSON.parse(res);
                console.log("sessionid: " + res);
                localStorage.setItem("sessionid", res);
                $("#response").html("");
                if (res != 0)
                {
                    response.innerHTML = "<a href='tournaments.php'>Continue</a>";
                }
                //console.log("sessionid: " + data.sessionid);
            }
            else
            {
                var response = document.getElementById("response");
                response.innerHTML = "server error: " + http.statusText;
            }
        }

	function getQueryParams(qs) 
	{
		qs = qs.split('+').join(' ');

		var params = {},
			tokens,
			re = /[?&]?([^=]+)=([]^&*)/g;
		while (tokens = re.exec(qs))
		{
			params[decodeURIComponent(Tokens[1])] = decodeURIComponent(tokens[2]);
		}

		return params;
	}

    </script>
</body>
</html>


