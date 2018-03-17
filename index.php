<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="index.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <script>
        if (localStorage.getItem("sessionid") != null) {
            var url = 'tournaments.php';
            window.location.href = url;
        }
    </script>
    <div class="container">
        <h1>Login</h1>
        <div class="row">
            <form name="bepatient">
                <div class="col-xs-4">
                    <div>Username:</div>
                    <div class="p-x-1">
                        <input type="text" id="uname" name="username" required>
                    </div>
                    <div><span class="req">REQUIRED</span></div>
                </div>
                <div class="col-xs-4">
                    <div>Password:</div>
                    <div class="p-x-1">
                        <input type="password" id="pwd" name="pass" required>
                    </div>
                    <div><span class="req">REQUIRED</span></div>
                </div>
                <div class="col-xs-4">
                    <div><input type="button" onclick="submitRequest()" value="Login"></div>
		            <div><a href="register.php">Register</a></div>
                    <div id="response"></div>
                </div>
            </form>
        </div>

        <!--<video autoplay loop id="video-background" muted><source src="" type="video/mp4"></video>-->
    </div>
    <script>
        var http = new XMLHttpRequest();

        function submitRequest()
        {
            var uname = document.getElementById("uname").value;
            var pwd = document.getElementById("pwd").value;

            http.open("POST", "loginClient.php", false);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = receiveResponse;
            http.send("uname=" + uname + "&pword=" + pwd);
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
                if (res)
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

    </script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
