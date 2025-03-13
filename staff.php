<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title> 
    
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 550px;
            margin: 0 auto; 
            margin-bottom: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info, .appointments {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
        .info p, .appointments table {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
            text-align: left; 
        }
        button {
            display: inline-block;
        }
    </style>



</head>
<body>
<?php

    session_start();


	$host = 'dragon.ukc.ac.uk';
	$dbname = 'lg565';
	$user = 'lg565';
	$pwd = 'rles3ev';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$_SESSION['name'] = htmlspecialchars($_POST['name']);
    $_SESSION['staffID'] = htmlspecialchars($_POST['staffID']);
    }

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare 
    $stmt = $conn->prepare("SELECT sName, pName, aDate, aTime  
                FROM Appointment a 
                LEFT JOIN Patient p 
                ON a.pID = p.pID
                LEFT JOIN Staff s
                ON a.sID = s.sID 
                WHERE s.sName = :name AND a.sID = :staffID ;");
     
     $stmt->bindParam(':name', $_SESSION['name']);
     $stmt->bindParam(':staffID', $_SESSION['staffID']);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($result) > 0) {
            // Credentials are correct, proceed with login
            
        echo "<h1 class = 'header'> COMP 8870 Healthcare Appointments </h1>"; 
        echo "<div class='container'><strong>Doctor Information:</strong> Displaying information for $_SESSION[name] (sID = $_SESSION[staffID]) <button class='btn btn-primary' onclick=\"window.location.href='index.php';\">Exit</button> </div>";
	    try {
		        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
		        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        
                $stmt = $conn->prepare("SELECT sName, pName, aDate, aTime, p.pID as pID 
                FROM Appointment a 
                LEFT JOIN Patient p 
                ON a.pID = p.pID
                LEFT JOIN Staff s
                ON a.sID = s.sID 
                WHERE s.sName = :name AND a.sID = :staffID ;");
     
                $stmt->bindParam(':name', $_SESSION['name']);
                $stmt->bindParam(':staffID', $_SESSION['staffID']);

                //$stmt = $pdo->prepare($sql);


		        //$handle = $conn->prepare($sql);

                
		        $stmt->execute();
		        $res = $stmt->fetchAll();
		
            echo "<div class='container'>";
            echo "<table>";
            echo "<tr><th>Patient</th><th>Date</th><th>Time</th><th>Action</th></tr>";
            foreach($res as $row) {
            echo "</td><td>".$row['pName']."</td><td>".$row['aDate']."</td><td>".$row['aTime']."</td>";
            echo "<td><div class='d-flex justify-content-center'>   
                    <form action='move.php' method='post'>
                        <input type='hidden' name='sID' value='".$_SESSION['staffID']."'>
                        <input type='hidden' name='pID' value='".$row['pID']."'>
                        <input type='hidden' name='aDate' value='".$row['aDate']."'>
                        <input type='hidden' name='aTime' value='".$row['aTime']."'>    
                        <button class='btn btn-primary'> Move</button> 
                    </form> 
                 </div></td></tr>";
            }
            echo "</table>";
            echo "</div>";
		    // code that uses $conn
		    $conn = null; 




         } catch (PDOException $e) {
		    echo "PDOException: ".$e->getMessage();
	        }
        } else {
            // Credentials are incorrect, redirect to error page
            header("Location: index.php");
            exit();
        }
     
?>


</body>
</html>