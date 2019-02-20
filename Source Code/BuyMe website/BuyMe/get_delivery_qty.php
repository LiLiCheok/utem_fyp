<?php

try {
	
	include 'db_conn.php';
	
	$user_id = $_POST['user_id'];
	$shop_id = $_POST['shop_id'];
	
	$query = "SELECT SUM(c.subtotal) as total FROM cart c, product p, shop s WHERE p.shop_id = s.shop_id AND c.product_id=p.product_id AND p.shop_id = '$shop_id' AND status='$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row) {
		$del_qty = $row['total'];
	}
	
	echo $del_qty;
	
} catch(PDOException $e) {
	echo "Error : " . $e->getMessage();
}

?>