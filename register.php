<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sign Up</title>
    <link rel="stylesheet" href="index.css" type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>

    <div class="container">

        <div id="login-form">

            <form autocomplete="off">

                <div class="col-md-12">

                    <div class="form-group">
                        <h2 class="">Register</h2>
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
                            <input type="text" id="uname" name="uname" class="form-control" placeholder="Username" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <input type="password" id="pw" name="pass" class="form-control" placeholder="Password"
                                required/>
                        </div>
                    </div>
                    
            
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <input type="password" id="pw2" name="pass2" class="form-control" placeholder="Confirm Password"
                                required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <input type="text" id="ingamename" name="ingamename" class="form-control" placeholder="League of Legends username"
                                required/>
                        </div>
                    </div>

    
                    <div class="form-group">
                        <button type="button" class="btn btn-block btn-primary" onclick="registerReq()" name="signup" id="reg">Register</button>
                    </div>

                    <div class="form-group">
                        <hr/>
                    </div>

                    <div class="form-group">
                        <a href="index.php" type="button" class="btn btn-block btn-success" name="btn-login">Login</a>
                    </div>

                </div>

            </form>
            <div id="response">
                
            </div>
        </div>

    </div>

    <script>
        var http = new XMLHttpRequest();

        function registerReq()
        {
            var pwd = document.getElementById("pw").value;
            var pw2 = document.getElementById("pw2").value;
            if (pwd == pw2)
            {
                var uname = document.getElementById("uname").value;
                var email = document.getElementById("email").value;
                var ingamename = document.getElementById("ingamename").value;
                http.open("POST", "registerClient.php", false);
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.onreadystatechange = receiveResponse;
                http.send("uname=" + uname + "&password=" + pwd + "&email=" + email + "&ingamename=" + ingamename);
            }
            else
            {
                $("#response").html("password fields don't match");
            }
        }

        function receiveResponse()
        {
            if (http.readyState == 4)
            {
                var res = http.responseText;
                /*var testresponse = document.getElementById("response");
                testresponse.innerHTML = res;
                var data = JSON.parse(res);
                console.log("sessionid: " + data);*/
                localStorage.setItem("sessionid", res.toString());
                var url = 'tournaments.php';
                window.location.href = url;
                
            }
            else
            {
                var testresponse = document.getElementById("testresponse");
                testresponse.innerHTML = "readystate not 4: " + http.readyState;
            }
        }
    </script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
