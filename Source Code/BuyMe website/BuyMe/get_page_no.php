<?php

try{
	
	include 'db_conn.php';
	
	$category_id = $_POST['category_id'];
	
	if($category_id=="all") {
		
		$query = "SELECT DISTINCT p.*, s.* FROM product p, shop s WHERE p.shop_id = s.shop_id AND product_status='active'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$count_row = $stmt->rowCount();
		
		if($count_row!=0) {
			$page = ceil($count_row/6);
			echo $page;
		} else {
			echo "no_product";
		}
	} else {
		
		$query = "SELECT DISTINCT p.*, s.* FROM product p, shop s WHERE p.shop_id = s.shop_id AND product_status='active' AND category_id='$category_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$count_row = $stmt->rowCount();
		
		if($count_row!=0) {
			$page = ceil($count_row/6);
			echo $page;
		} else {
			echo "no_product";
		}
	}
} catch(PDOExeption $e) {
	
	echo "Error : " . $e->getMessage();
}

?>