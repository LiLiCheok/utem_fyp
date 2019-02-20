<?php

try {
	
	include_once '../db_conn.php';
	
	$user_id = $_POST['user_id'];
	
	$query = "SELECT DISTINCT p.*, c.category_name FROM product p, shop s, category c WHERE p.product_status='active' AND p.shop_id=s.shop_id AND p.category_id=c.category_id AND s.user_id='$user_id' ORDER BY post_at DESC, p.product_id DESC";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$count_row = $stmt->rowCount();
	$page = ceil($count_row/4);
	
	echo $page;
	
} catch(PDOExeption $e) {
	
	echo "Error: ".$e->getMessage();
}

?>