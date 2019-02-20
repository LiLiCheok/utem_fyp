<?php

try {

	include_once '../db_conn.php';
		
	$order_id = $_POST['order_id'];
	$status = $_POST['status'];
	$product_id = $_POST['product_id'];
	
	$query = "UPDATE cart SET status='$status' WHERE product_id='$product_id' AND order_id='$order_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	echo "updated";
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>