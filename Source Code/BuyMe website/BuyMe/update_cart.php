<?php

try {

	include_once 'db_conn.php';
		
	$user_id = $_POST['user_id'];
	$product_id = $_POST['product_id'];
	$quantity = $_POST['quantity'];
	
	$query1 = "SELECT product_price FROM product WHERE product_id='$product_id'";
	$stmt1 = $conn->prepare($query1);
	$stmt1->execute();
	$result = $stmt1->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row) {
		$price = $row['product_price'];
	}
	
	$subtotal = $quantity * $price;
	
	$query = "UPDATE cart SET quantity = '$quantity', subtotal = '$subtotal' WHERE product_id='$product_id' AND status='$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	echo "updated";
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>