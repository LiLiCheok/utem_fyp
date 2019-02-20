<?php

try {

	include_once 'db_conn.php';
	
	$email = $_POST['email'];
	$newpass = $_POST['new_pass'];
	
	$query = "UPDATE user SET user_password = '$newpass' WHERE user_email = '$email'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	echo "reset_successfully";
	
} catch(PDOException $e) {

	echo "Error: ' . '".$e->getMessage()."'";
}

?>