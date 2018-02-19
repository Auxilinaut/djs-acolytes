var http = new XMLHttpRequest();

        function submitRequest()
        {
            var uname = document.getElementById("uname").value;
            var pwd = document.getElementById("pwd").value;

            http.open("POST", "../../testRabbitMQClient.php", true);
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            http.onreadystatechange = receiveResponse;
            http.send("uname=" + uname + "&pword=" + pwd);
        }

        function receiveResponse()
        {
            if (http.readyState == 4)
            {
                var res = http.responseText;
                var testresponse = document.getElementById("testresponse");
                testresponse.innerHTML = res;
            }
            else
            {
                var testresponse = document.getElementById("testresponse");
                testresponse.innerHTML = "readystate not 4: " + http.readyState;
            }
        }
