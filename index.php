<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NHS Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f6f8fa;
            margin: 0;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #24292f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #444d56;
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #0366d6;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .divider:before, .divider:after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ccc;
        }

        .divider span {
            padding: 0 10px;
            font-size: 14px;
            color: #666;
        }

        .heading-container {
            margin-right: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .form {
            display: none; /* Hide forms by default */
        }


    </style>

<script>
    function showForm(formId) {
        // Hide all forms
        document.getElementById('formUser').style.display = 'none';
        document.getElementById('formStaff').style.display = 'none';
        
        // Show the selected form
        document.getElementById(formId).style.display = 'block';
    }
</script>
</head>
<body>

    <div class="heading-container">
        <h1> COMP 8870 Healthcare </h1>
        <img src="NHSLogoFinal.png" alt="NHS Logo" width="150" height="100"> 
    </div>

    <div class="login-container">

        <div class="divider">
            <span>1.Choose login type</span>
        </div>

        
        <button onclick="showForm('formUser')" class="btn" style="background-color: #003087;">Patient Login</button>
        <button onclick="showForm('formStaff')" class="btn" style="background-color: #41B6E6;">Staff Login</button>
          

        <form id = 'formUser' action="patient.php" method="post" class = "form" >
            
            <h2>Patient Login</h2>
            
            <div class="divider">
                <span>2.Enter credentials</span>
            </div> 

            <input type="text" class="input-field" placeholder="Enter Patient ID" name="patientID" >

            <div class="divider">
                <span>OR</span>
            </div> 

            <input type="text" class="input-field" placeholder="Enter NHS Number" Name ="NHSNumber" > 
            
            <div class="divider">
                <span>3.Press enter</span>
            </div>
    
            <button id = "enter button" type="submit" class="btn">Enter</button>
        </form>

        <form id = 'formStaff' action="staff.php" method="post" class = "form" >
           
            <h2>Staff Login</h2>

            <div class="divider">
                <span>2.Enter credentials</span>
            </div> 

            <input type="text" class="input-field" placeholder="Enter Staff ID" name="staffID" required>
            <input type="text" class="input-field" placeholder="Enter Name" name="name" required>
            
            <div class="divider">
                <span>3.Press enter</span>
            </div>
    
            <button id = "enter button" type="submit" class="btn">Enter</button>

        </form>

        
   
    </div>

</body>
</html>