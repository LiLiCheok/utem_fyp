<?php

try {

	include_once 'db_conn.php';
		
	$order_id = $_POST['order_id'];
	
	$query = "select * from cart where status='' AND order_id='$order_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$row = $stmt->rowCount();
	if($row!=0) {
		echo "not_settle";
	} else {
		echo "settle";
	}
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>