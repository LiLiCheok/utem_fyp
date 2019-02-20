<?php
	
	session_start();
	
	if(isset($_GET['userID'])) {
		
		$userID = $_GET['userID'];
		$datetime = date('Y-m-d H:i:s', time());
		
		try {
	
			include_once '../db_conn.php';
		
			$query = "UPDATE user SET create_at = '$datetime' WHERE user_name = '$userID'";
			$stmt = $conn->prepare($query);
			$stmt->execute();
		
		} catch(PDOException $e) {
	
			echo "Error: " . $e->getMessage();
		}
		
		session_destroy();
		
		header('location: /BuyMe/admin');
	
	}

?>