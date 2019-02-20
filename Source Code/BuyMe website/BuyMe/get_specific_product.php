<?php

try {
	include_once 'db_conn.php';
	
	$product_id = $_POST['product_id'];
	
	$query1 = "SELECT DISTINCT p.*, s.* FROM product p, shop s
	WHERE p.shop_id = s.shop_id AND p.product_status='active' and p.product_id='$product_id'";
	$stmt1 = $conn->prepare($query1);
	$stmt1->execute();
	$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
	foreach($result1 as $row) {
		$shop_location = $row['shop_location'];
	}
	
	if($shop_location==null) {
		$query = "SELECT p.*, s.*, c.*, u.*, a.* FROM product p, shop s, category c, user u, address a
		WHERE p.shop_id = s.shop_id AND p.category_id=c.category_id AND s.user_id=u.user_id AND u.user_id=a.user_id
		AND p.product_status='active' AND p.product_id='$product_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$count_row = $stmt->rowCount();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if($count_row!=0) {
			
			echo json_encode($result);
			
		} else if($count_row==0){
			
			echo "no_product";
		}
	} else {
		$query = "SELECT p.*, s.*, c.*, u.* FROM product p, shop s, category c, user u
		WHERE p.shop_id = s.shop_id AND p.category_id=c.category_id AND s.user_id=u.user_id
		AND p.product_status='active' AND p.product_id='$product_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$count_row = $stmt->rowCount();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if($count_row!=0) {
			
			echo json_encode($result);
			
		} else if($count_row==0){
			
			echo "no_product";
		}
	}
	
} catch(PDOException $e) {
	
	echo "Error: ".$e->getMessage();
}

?>