<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Physician/Patient Portal</title>
    <link href="index.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="vidup">
        <h1>Physician/Patient Portal</h1>
        <div class="wrapper d-flex p-y-3">
            <form method="post" action="updateform.php" name="patient" id="pForm">
                <div class="d-flex p-y-1">
                    <div>Patient Name:</div>
                    <div class="p-x-1">
                        <input type="text" id="pName" name="patientName" required>
                    </div>
                    <div><span class="req">REQUIRED</span></div>
                </div>
                <div class="d-flex p-y-1">
                    <div>Patient ID:</div>
                    <div class="p-x-1">
                        <input type="password" id="pId" name="patientId" required>
                    </div>
                    <div><span class="req">REQUIRED</span></div>
                </div>
                <div class="d-flex p-y-1">
                    <div>Patient Email:</div>
                    <div class="p-x-1">
                        <input type="text" id="pEmail" name="patientEmail">
                    </div>
                    <div><span id="emailReq" class="req"></span></div>
                </div>
                <div class="d-flex p-y-1">
                    <div>Email me a confirmation:</div>
                    <div class="p-x-1">
                        <input type="checkbox" id="email" name="emailMe" onclick="emailRequired()">
                    </div>
                </div>
                <div class="d-flex">
                    <div>I want to:</div>
                    <div class="p-x-1">
                        <select name="pAction">
                            <option value="appointment">Make an appointment</option>
                            <option value="records">Request medical records</option>
                        </select>
                    </div>
                    <div>
                        <input type="submit" name="submit" class="button" value="Continue >>">
                    </div>
                </div>
            </form>
        </div>

        <video autoplay loop id="video-background" muted>
            <source src="https://web.njit.edu/~jj246/it202-assignment2/patient-portal-bgvid-justin-johnson.webm" type="video/mp4">
        </video>
    </div>

    <script>
        function emailRequired()
        {
            // Div holding "REQUIRED" text
            var emailReq = document.getElementById("emailReq");
            var pForm = document.getElementById("pForm");

            pForm.patientEmail.required = pForm.emailMe.checked;
        
            if (pForm.patientEmail.required) emailReq.innerText = "REQUIRED";
            else emailReq.innerText = "";
        }
    </script>

</body>

</html>

