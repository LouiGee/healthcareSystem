<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title> 
</head>
<body>
<?php

$host = 'dragon.ukc.ac.uk';
$dbname = 'lg565';
$user = 'lg565';
$pwd = 'rles3ev';

//htmlspecialchars to sanitise input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['patientID'] = htmlspecialchars($_POST['patientID']);
    $_SESSION['NHSNumber'] = htmlspecialchars($_POST['NHSNumber']);
}


//Validation
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
// Retrieve Patients
$stmtValidation = $conn->prepare("SELECT * 
            FROM Patient
            WHERE pID = :patientID AND pNHSNo = :NHSNumber ;");
 
 $stmtValidation->bindParam(':patientID', $_SESSION['patientID']);
 $stmtValidation->bindParam(':NHSNumber', $_SESSION['NHSNumber']);

// Execute the statement
$stmtValidation->execute();

// Get the result
$result = $stmtValidation->fetchAll(PDO::FETCH_ASSOC);


if (count($result) > 0) {
    //If patient present then the SQL query will return a result

    echo "Valid patient credentials";

}   else {
    // Credentials are incorrect, redirect to index page
    header("Location: index.php");
    exit();
}  
?>



</body>
</html>