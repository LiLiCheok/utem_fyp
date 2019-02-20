<?php

try {

	include_once 'db_conn.php';
		
	$user_id = $_POST['user_id'];
	
	$query = "SELECT c.*, p.product_id, p.product_name, p.product_price, p.product_image, s.shop_id, s.shop_name, s.delivery_service, s.delivery_info from product p, cart c, shop s WHERE p.product_id = c.product_id AND status='$user_id' AND p.shop_id = s.shop_id ";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$row = $stmt->rowCount();
	if($row!=0) {
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	} else {
		echo "no_product";
	}
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>