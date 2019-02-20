<?php

try {
	include_once '../db_conn.php';
	
	$user_id = $_POST['user_id'];
	$category_id = $_POST['category_id'];
	$product_name = $_POST['product_name'];
	$product_image = $_POST['product_image'];
	$product_desc = $_POST['product_desc'];
	$product_price_main = $_POST['product_price'];
	$product_price_cent = $_POST['product_price_cent'];
	$product_price = $product_price_main.".".$product_price_cent;
	
	$query = "SELECT(SELECT COUNT(product_id) FROM product) as num_product, (SELECT shop_id FROM shop WHERE user_id='$user_id') as shop_id";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row) {
		$old_pid = $row['num_product'];
		$shop_id = $row['shop_id'];
	}
	
	if($old_pid!=0||$old_pid==0) {
		$product_id = 'P'.sprintf("%019s", $old_pid+1);
		$post_at = date("Y-m-d");
		
		$query_1 = "INSERT INTO product (product_id, product_image, product_name, product_desc, product_price, post_at, category_id, shop_id, product_status) VALUES ('$product_id', '$product_image', '$product_name', '$product_desc', '$product_price', '$post_at', '$category_id', '$shop_id', 'active')";
		$stmt_1 = $conn->prepare($query_1);
		$stmt_1->execute();
		
		echo "added";
	}
	
} catch(PDOExeption $e) {
	
	echo "Error: ".$e->getMessage();
}

?>