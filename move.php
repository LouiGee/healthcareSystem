<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delegation</title> 
    
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

$host = 'dragon.ukc.ac.uk';
	$dbname = 'lg565';
	$user = 'lg565';
	$pwd = 'rles3ev';

$sID =  $_POST['sID'];
$pID = $_POST['pID'];
$aDate = $_POST['aDate'];
$aTime =  $_POST['aTime'];

echo "<h1 class = 'header'> COMP 8870 Healthcare Delegation </h1>"; 
echo "<div class='container'> Alternatives for appointment on at by sID = $sID <button class='btn btn-primary' onclick=\"window.location.href='index.php';\">Exit</button> </div>";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    

    $sql = "SELECT sName, sType, sID 
            FROM Staff WHERE sID != '$sID' 
            AND sID NOT IN 
            (SELECT sID FROM Appointment
            WHERE aDate = '$aDate'  AND aTime = '$aTime');";
    $handle = $conn->prepare($sql);
    $handle->execute();
    $res = $handle->fetchAll();

echo "<div class='container'>";

echo "<form action='delegate.php' method='post'>";
echo "<table>";
echo "<tr><th>Name</th><th>Type</th><th>sID</th><th></tr>";

foreach($res as $row) {

echo "</td><td>".$row['sName']."</td><td>".$row['sType']."</td><td>".$row['sID']."</td><td>";

echo "<div class='d-flex justify-content-center'> 
        <input type='radio' name='delegate_sID' value='".$row['sID']."'> </div>
        </td></tr>";
}
echo "</table>";
echo " <input type='hidden' name='oldsID' value='".$sID."'>
       <input type='hidden' name='aDate' value='".$aDate."'>
       <input type='hidden' name='aTime' value='".$aTime."'>
       <input type='hidden' name='pID' value='".$pID."'>";

echo  "<button class='btn btn-primary' type='submit'> Delegate</button></th></tr>";
echo  "</form>";

echo "</div>";
// code that uses $conn
$conn = null; 
} catch (PDOException $e) {
echo "PDOException: ".$e->getMessage();
}
     
?>


</body>
</html>