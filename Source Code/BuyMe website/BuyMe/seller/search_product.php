<?php

try {
	include_once '../db_conn.php';
	
	$search_data = $_POST['search_data'];
	$user_id = $_POST['user_id'];
	
	$query = "SELECT DISTINCT p.*, c.category_name FROM product p, shop s, category c WHERE p.product_status='active' AND p.shop_id=s.shop_id AND p.category_id=c.category_id AND s.user_id='$user_id' AND CONCAT(product_id, product_name) LIKE '%".$search_data."%' ORDER BY post_at DESC";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$count_row = $stmt->rowCount();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if($count_row!=0) {
		
		echo json_encode($result);
		
	} else if($count_row==0){
		
		echo "no_product";
	}
	
} catch(PDOExeption $e) {
	
	echo "Error: ".$e->getMessage();
}

?>