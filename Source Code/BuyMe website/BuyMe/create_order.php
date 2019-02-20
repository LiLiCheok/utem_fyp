<?php

try {
	
	include 'db_conn.php';
	
	$user_id = $_POST['user_id'];
	$order_total = $_POST['total'];
	
	// Create order id
	$query = "SELECT * FROM orders";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$row = $stmt->rowCount();
	$order_id = 'OD'.sprintf("%018s", $row+1);
	
	$query1 = "INSERT INTO orders (order_id, order_time, order_total, order_status, user_id) VALUE ('$order_id', CURRENT_TIMESTAMP, '$order_total', 'sent', '$user_id')";
	$stmt1 = $conn->prepare($query1);
	$stmt1->execute();
	
	$query2 = "UPDATE cart SET status='', order_id='$order_id' WHERE status='$user_id'";
	$stmt2 = $conn->prepare($query2);
	$stmt2->execute();
	
	echo "ordered";
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>