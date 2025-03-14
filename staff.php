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
            width: 600px;
            margin: 20px auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info, .appointments, .prescriptions {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
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
            margin-top: 10px;
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


//Define session variables only when page is accessed from the login page html specialchars used to santitise input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['name'] = htmlspecialchars($_POST['name']);
    $_SESSION['staffID'] = htmlspecialchars($_POST['staffID']);
}

try {
    
    echo "<h1 class='header'>COMP 8870 Healthcare Appointments</h1>";

    echo "<div class='container'>";
    echo "<strong>Doctor Information:</strong> Displaying information for {$_SESSION['name']} (sID = {$_SESSION['staffID']})";
    echo "<button onclick=\"window.location.href='index.php';\">Exit</button>";
    echo "</div>";

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve Appointments
    $stmtAppointments = $conn->prepare("SELECT sName, pName, aDate, aTime, p.pID as pID 
                FROM Appointment a 
                LEFT JOIN Patient p ON a.pID = p.pID
                LEFT JOIN Staff s ON a.sID = s.sID 
                WHERE s.sName = :name AND a.sID = :staffID;");

    // Binding helps prevent SQL injection attacks
    $stmtAppointments->bindParam(':name', $_SESSION['name']);
    $stmtAppointments->bindParam(':staffID', $_SESSION['staffID']);

    $stmtAppointments->execute();

    $resAppointments = $stmtAppointments->fetchAll();

    echo "<div class='container'>";
    echo "<h2 class='header'>Appointments</h2>";
    echo "<table>";
    echo "<tr><th>Patient</th><th>Date</th><th>Time</th><th>Action</th></tr>";

    foreach ($resAppointments as $row) {
        echo "<tr>";
        echo "<td>{$row['pName']}</td><td>{$row['aDate']}</td><td>{$row['aTime']}</td>";
        echo "<td>
                <form action='move.php' method='post'>
                    <input type='hidden' name='sID' value='{$_SESSION['staffID']}'>
                    <input type='hidden' name='pID' value='{$row['pID']}'>
                    <input type='hidden' name='aDate' value='{$row['aDate']}'>
                    <input type='hidden' name='aTime' value='{$row['aTime']}'>    
                    <button>Move</button>
                </form> 
              </td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";

    // Retrieve Prescriptions
    $stmtPrescriptions = $conn->prepare("SELECT pID AS Patient, m.mID, psmDate AS Date, mName AS Name, mDosage AS Dosage, quantity*cost AS Price
                FROM Medication m 
                JOIN Patient_Staff_Medication p ON m.mID = p.mID 
                WHERE p.sID = :staffID 
                ORDER BY p.pID, p.mID, p.psmDate DESC;");

    // Binding helps prevent SQL injection attacks
    $stmtPrescriptions->bindParam(':staffID', $_SESSION['staffID']);
    $stmtPrescriptions->execute();

    $resPrescriptions = $stmtPrescriptions->fetchAll();

    echo "<div class='container'>";
    echo "<h2 class='header'>Prescriptions</h2>";
    echo "<table>";
    echo "<tr><th>Patient</th><th>mID</th><th>Date</th><th>Name</th><th>Dosage</th><th>Price</th><th>Delete</th></tr>";

    foreach ($resPrescriptions as $row) {
        echo "<tr>";
        echo "<td>{$row['Patient']}</td><td>{$row['mID']}</td><td>{$row['Date']}</td><td>{$row['Name']}</td><td>{$row['Dosage']}</td><td>{$row['Price']}</td>";
        echo "<td>
                <form action='delete.php' method='post'>
                    <input type='hidden' name='pID' value='{$row['Patient']}'>
                    <input type='hidden' name='mID' value='{$row['mID']}'>
                    <input type='checkbox' name='delete[]' value='{$row['mID']['Patient']}'>

                 
              </td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<button id = 'enter button' type='submit' class='btn'>Delete</button>";
    echo "</form>";
    echo "</div>";

    $conn = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

</body>
</html>