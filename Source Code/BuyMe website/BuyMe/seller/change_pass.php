<?php

try {
	
	include '../db_conn.php';
	
	$user_id = $_POST['user_id'];
	$new_pass = $_POST['new_pass'];
	$old_pass = $_POST['old_pass'];
	
	$query = "SELECT user_password FROM user WHERE user_id='$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$count_row = $stmt->rowCount();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if ($count_row == 1) {
		
		foreach($result as $row) {
			$user_pass = $row['user_password'];
		}
		
		if($old_pass!=$user_pass) {
			echo "same_pass";
		} else {
			
			$query = "UPDATE user SET user_password = '$new_pass' WHERE user_id='$user_id'";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			echo "changed";
		}
	}
	
} catch(PDOExeption $e) {
	
	echo "Error: " . $e->getMessage();
}

?>