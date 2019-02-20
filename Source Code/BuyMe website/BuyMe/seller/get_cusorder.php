<?php

try {

	include_once '../db_conn.php';
		
	$user_id = $_POST['user_id'];
	
	$query = "SELECT DISTINCT o.* FROM cart c, orders o, product p, shop s WHERE c.order_id = o.order_id AND c.product_id = p.product_id AND p.shop_id = s.shop_id AND s.user_id = '$user_id'";
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