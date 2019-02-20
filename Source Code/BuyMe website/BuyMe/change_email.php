<?php

try {
	
	include 'db_conn.php';
	
	$user_id = $_POST['user_id'];
	$new_mail = $_POST['new_mail'];
			
	$query = "UPDATE user SET user_email = '$new_mail' WHERE user_id='$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	echo "changed";
	
} catch(PDOExeption $e) {
	
	echo "Error: " . $e->getMessage();
}

?>