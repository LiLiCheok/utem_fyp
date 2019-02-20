<?php

try {

	include_once 'db_conn.php';
		
	$user_id = $_POST['user_id'];
	
	$query = "select distinct o.order_id, c.status from cart c, orders o where o.order_id = c.order_id AND c.status='' AND o.user_id='$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$row = $stmt->rowCount();
	if($row!=0) {
		echo $row;
	} else {
		echo "no_order";
	}
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>