<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delegation</title> 
</head>
<body>
<?php

session_start();

     $host = 'dragon.ukc.ac.uk';
     $dbname = 'lg565';
     $user = 'lg565';
     $pwd = 'rles3ev';

     $submittedData = $_POST['delete'];
     
         // Credentials are correct, proceed with login
 
     foreach ($submittedData as $row) {

        // string exploded to mid and PatientID array to be used in array
        $parts = explode('_', $row);


        try {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        
                $sql = "DELETE FROM Prescription 
                        WHERE mID = '$parts[0]'
                        AND pID = '$parts[1]';";
                
                //No need to bind parameters because values are not input values
                        
                $handle = $conn->prepare($sql);
                $handle->execute();

                // $result = $handle->fetchAll(PDO::FETCH_ASSOC);

    
            // code that uses $conn
            $conn = null; 

        } catch (PDOException $e) {
            echo "PDOException: ".$e->getMessage();
            }
            
        }
            header("Location: staff.php");
            exit();

?>
</body>
</html>