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

     print_r( $submittedData );
     


         // Credentials are correct, proceed with login
 
     //foreach ($submittedData as $row) {

       // echo "{$row['Patient']}";
       // echo "{$row['mID']}";

     //}

     /*

        try {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        
                $sql = "UPDATE Appointment SET sID = '$newsID' 
                        WHERE aDate = '$aDate'
                        AND aTime = '$aTime'
                        AND pID = '$pID'
                        AND sID = '$oldID';";
                        
                $handle = $conn->prepare($sql);
                $handle->execute();

                $result = $handle->fetchAll(PDO::FETCH_ASSOC);

    
            // code that uses $conn
            $conn = null; 

        } catch (PDOException $e) {
            echo "PDOException: ".$e->getMessage();
            }
            
            header("Location: staff.php");
            exit();

  */
?>
</body>
</html>