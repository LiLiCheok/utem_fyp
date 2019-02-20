<?php

try{
	
	include_once 'db_conn.php';
	
	$category_id = $_POST['category_id'];
	$page_start = $_POST['page_start'];
	
	if($page_start==""||$page_start==1) {
		$page=0;
	} else {
		$page=($page_start*6)-6;
	}
	
	if($category_id=="all") {
		
		$query = "SELECT DISTINCT p.*, s.* FROM product p, shop s WHERE p.shop_id = s.shop_id AND p.product_status='active'
		ORDER BY p.post_at DESC, p.product_id DESC
		LIMIT $page, 6";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$count_row = $stmt->rowCount();
		
		if($count_row!=0) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($result);
		} else {
			echo "no_product";
		}
	} else {
		
		$query = "SELECT DISTINCT p.*, s.* FROM product p, shop s WHERE p.shop_id = s.shop_id AND p.product_status='active' AND p.category_id='$category_id'
		ORDER BY p.post_at DESC, p.product_id DESC
		LIMIT $page, 6";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$count_row = $stmt->rowCount();
		
		if($count_row!=0) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($result);
		} else {
			echo "no_product";
		}
	}
} catch(PDOException $e) {
	
	echo "Error : " . $e->getMessage();
}

?>