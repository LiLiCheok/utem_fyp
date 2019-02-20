<?php

	try {
		include_once '../db_conn.php';
	
		if(isset($_GET['catID'])) {
		
			$catID = $_GET['catID'];
			$query = "UPDATE category SET status='deleted' WHERE category_id='$catID'";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			
			header("location: home.php");
		}
	} catch(PDOException $e) {

		echo "Error: " . $e->getMessage();
	}

?>