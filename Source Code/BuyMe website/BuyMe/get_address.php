<?php

try {
	
	include 'db_conn.php';
	
	$user_id = $_POST['user_id'];
	
	$query = "SELECT * FROM address WHERE user_id = '$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$row = $stmt->rowCount();
	if($row!=0){
		echo "address_added";
	} else {
		echo "address_null";
	}
	
} catch(PDOException $e) {
	echo "Error : " . $e->getMessage();
}

?>