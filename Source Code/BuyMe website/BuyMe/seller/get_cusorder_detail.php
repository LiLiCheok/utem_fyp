<?php

try {

	include_once '../db_conn.php';
		
	$user_id = $_POST['user_id'];
	$order_id = $_POST['order_id'];
	
	$query = "SELECT o.*, c.*, u.*, p.*, s.*, a.* FROM cart c, orders o, product p, shop s, user u, address a WHERE c.order_id = o.order_id AND c.product_id = p.product_id AND p.shop_id = s.shop_id AND o.user_id = u.user_id AND a.user_id = u.user_id AND o.order_id = '$order_id' AND s.user_id = '$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$row = $stmt->rowCount();
	if($row!=0) {
		$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	} else {
		echo "no_order";
	}
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>