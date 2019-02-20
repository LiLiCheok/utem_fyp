<?php

try {

	include_once '../db_conn.php';
		
	$user_id = $_POST['user_id'];
	
	$query = "SELECT DISTINCT o.order_id, c.status FROM cart c, orders o, product p, shop s WHERE c.order_id = o.order_id AND c.product_id = p.product_id AND p.shop_id = s.shop_id AND s.user_id = '$user_id' AND c.status=''";
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