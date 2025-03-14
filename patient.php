<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title> 
</head>
<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['name'] = htmlspecialchars($_POST['name']);
    $_SESSION['staffID'] = htmlspecialchars($_POST['staffID']);
}


//Validation
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prepare 
 
// Retrieve Appointments
$stmtValidation = $conn->prepare("SELECT sName, pName, aDate, aTime, p.pID as pID 
            FROM Appointment a 
            LEFT JOIN Patient p 
            ON a.pID = p.pID
            LEFT JOIN Staff s
            ON a.sID = s.sID 
            WHERE s.sName = :name AND a.sID = :staffID ;");
 
 $stmtValidation->bindParam(':name', $_SESSION['name']);
 $stmtValidation->bindParam(':staffID', $_SESSION['staffID']);

// Execute the statement
$stmtValidation->execute();

// Get the result
$result = $stmtValidation->fetchAll(PDO::FETCH_ASSOC);


if (count($result) > 0) {


    try {
        
        echo "<h1 class='header'>COMP 8870 Healthcare</h1>";

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
            echo "<td>{$row['pName']} (pID {$row['pID']})</td><td>{$row['aDate']}</td><td>{$row['aTime']}</td>";
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
        echo "<form action='delete.php' method='post'>";
        echo "<table>";
        echo "<tr><th>Patient</th><th>mID</th><th>Date</th><th>Name</th><th>Dosage</th><th>Price</th><th>Delete</th></tr>";

        foreach ($resPrescriptions as $row) {
            echo "<tr>";
            echo "<td>{$row['Patient']}</td><td>{$row['mID']}</td><td>{$row['Date']}</td><td>{$row['Name']}</td><td>{$row['Dosage']}</td><td>{$row['Price']}</td>";
            echo "<td>
                    
                        <input type='hidden' name='pID' value='{$row['Patient']}'>
                        <input type='hidden' name='mID' value='{$row['mID']}'>
                        <input type='checkbox' name='delete[]' value='{$row['mID']}_{$row['Patient']}'>

                    
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

}   else {
    // Credentials are incorrect, redirect to error page
    header("Location: index.php");
    exit();
}



    echo "<p> Welcome patient </p>"; 
?>
</body>
</html>