<?php

try {

	include_once 'db_conn.php';
		
	$user_id = $_POST['user_id'];
	$product_id = $_POST['product_id'];
	$shop_id = $_POST['shop_id'];
	$shop_item = $_POST['shop_item'];
	
	$query = "UPDATE cart SET quantity='', subtotal='', del_charge=NULL, status='' WHERE product_id='$product_id' AND status='$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$query1 = "SELECT SUM(c.quantity) as total FROM cart c, product p, shop s WHERE p.shop_id = s.shop_id AND c.product_id=p.product_id AND p.shop_id = '$shop_id' AND status='$user_id'";
	$stmt1 = $conn->prepare($query1);
	$stmt1->execute();
	$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
	foreach($result1 as $row1) {
		$del_qty = $row1['total'];
	}
	if($shop_item!="") {
		if($shop_item<=$del_qty) {
			
		} else {
			$q = "SELECT c.* FROM cart c, product p, shop s WHERE c.status='$user_id' AND c.product_id=p.product_id AND p.shop_id=s.shop_id AND s.shop_id='$shop_id'";
			$s = $conn->prepare($q);
			$s->execute();
			$r=$s->fetchAll(PDO::FETCH_ASSOC);
			foreach($r as $row) {
				$cart_id=$row['cart_id'];
				$query = "UPDATE cart SET del_charge=NULL WHERE cart_id='$cart_id'";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
		}
	} else {}
	
	echo "deleted";
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>