<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="index.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>


<?php
ob_start();
session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: index.php");
}
require_once 'connections/mysqlconnection.php';
//include('connections/mysqlconnection.php')

if (isset($_POST['signup'])) {

    $uname = trim($_POST['uname']); // get posted data and remove whitespace
    $email = trim($_POST['email']);
    $upass = trim($_POST['pass']);

    // hash password;
    //$password = hash('sha256', $upass);
   // $password = $_POST['password'];
  //  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    //$salt = sha1(md5($password)).'j732O8&2hU2p'; 
    //$password = md5($password.$salt);
     
    if ($_POST['pass']!= $_POST['pass2'])
    {
     echo("Oops! Password did not match! Try again. ");
    } 
  
    // check if email exists or not
    $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $count = $result->num_rows;

    if ($count == 0) { // if email is not found add user


        $stmts = $conn->prepare("INSERT INTO users(username,email,password) VALUES(?, ?, ?)");
        $stmts->bind_param("sss", $uname, $email, $password);
        $res = $stmts->execute();//get result
        $stmts->close();

        $user_id = mysqli_insert_id($conn);
        if ($user_id > 0) {
            $_SESSION['user'] = $user_id; // set session and redirect to index page
            if (isset($_SESSION['user'])) {
                print_r($_SESSION);
                header("Location: index.php");
                exit;
            }

        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again";
        }

    } else {
        $errTyp = "warning";
        $errMSG = "Email is already used";
    }
}

?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
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
                        <input type="text" id="uname" name="uname" class="form-control" placeholder="Enter Username" required/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" required/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" id="pw" name="pass" class="form-control" placeholder="Enter Password"
                               required/>
                    </div>
                </div>
                 
		
	        <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" id="pw2" name="pass2" class="form-control" placeholder="Confirm your Password"
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
                    <a href="login.php" type="button" class="btn btn-block btn-success" name="btn-login">Login</a>
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
            var uname = document.getElementById("uname").value;
            var pwd = document.getElementById("pw").value;
	    var email = 
            http.open("POST", "registerClient.php", false);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = receiveResponse;
            http.send("uname=" + uname + "&pword=" + pwd);
	    http.send("email=" + uname + "&pword=" + pwd);
            http.send("ingamename=" + uname + "&pword=" + pwd);	

        }
        function receiveResponse()
        {
            if (http.readyState == 4)
            {
                var res = http.responseText;
                var testresponse = document.getElementById("response");
                testresponse.innerHTML = res;
		var data = JSON.parse(res);
		console.log("sessionid: " + data);
            }
            else
            {
                var testresponse = document.getElementById("testresponse");
                testresponse.innerHTML = "readystate not 4: " + http.readyState;
            }
        }
</script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/tos.js"></script>

</body>
</html>
