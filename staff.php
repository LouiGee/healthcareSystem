<?php
	$host = 'dragon.ukc.ac.uk';
	$dbname = 'lg565';
	$user = 'lg565';
	$pwd = 'rles3ev';


    echo '<h1> COMP 8870 Healthcare </h1>'; 
    echo ' <div class="divider"> <h4> <b>Doctor Information:</b> Displaying information for <h4> </div> ';

	try {
		$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        
        $sql = "SELECT sName, pName, aDate, aTime  
                FROM Appointment a 
                LEFT JOIN Patient p 
                ON a.pID = p.pID
                LEFT JOIN Staff s
                ON a.sID = s.sID 
                WHERE sName =   ;"
		$handle = $conn->prepare($sql);
		$handle->execute();
		$res = $handle->fetchAll();
		
        echo "<ul>";
			foreach($res as $row) {
		echo "<li> Staff:".$row['sName']."Patient -".$row['pName']." - Date:".$row['aDate']."- Time:".$row['aTime']."</li>";
		}
		echo "</ul>";
		// code that uses $conn
		$conn = null; 
	} catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
?>
