<?php

try {

	include_once 'db_conn.php';
		
	$user_id = $_POST['user_id'];
	$shop_id = $_POST['shop_id'];
	$dc = $_POST['dc'];
	
	if($dc!="") {
		$query1 = "select c.product_id, s.delivery_info FROM cart c, shop s, product p where c.product_id = p.product_id and c.status='$user_id' and p.shop_id = s.shop_id and p.shop_id='$shop_id'";
		$stmt1 = $conn->prepare($query1);
		$stmt1->execute();
		$result = $stmt1->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$charge = $row['delivery_info'];
			$check_charge = substr($charge, 0, strpos($charge, "delivery"));
			if(trim($check_charge)=="Free") {
				$product_id = $row['product_id'];
				$query = "UPDATE cart SET del_charge = 0 WHERE product_id='$product_id' AND status='$user_id'";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			} else {
				$del_charge = substr($charge, 0, strpos($charge, "%"));
				$product_id = $row['product_id'];
				$query = "UPDATE cart SET del_charge = '$del_charge' WHERE product_id='$product_id' AND status='$user_id'";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
		}
		
		echo "updated";

	} else {
		$query1 = "select c.product_id, s.delivery_info FROM cart c, shop s, product p where c.product_id = p.product_id and c.status='$user_id' and p.shop_id = s.shop_id and p.shop_id='$shop_id'";
		$stmt1 = $conn->prepare($query1);
		$stmt1->execute();
		$result = $stmt1->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$charge = $row['delivery_info'];
			$check_charge = substr($charge, 0, strpos($charge, "delivery"));
			if(trim($check_charge)=="Free") {
				$product_id = $row['product_id'];
				$query = "UPDATE cart SET del_charge = NULL WHERE product_id='$product_id' AND status='$user_id'";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			} else {
				$product_id = $row['product_id'];
				$query = "UPDATE cart SET del_charge = NULL WHERE product_id='$product_id' AND status='$user_id'";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
		}
		
		echo "updated";
	}	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>