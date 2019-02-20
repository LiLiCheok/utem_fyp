<?php

try {

	include_once 'db_conn.php';
		
	$user_id = $_POST['user_id'];
	
	$query = "SELECT * FROM cart WHERE status = '$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$row = $stmt->rowCount();
	if($row!=0) {
		echo $row;
	} else {
		echo "no_cart";
	}
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>