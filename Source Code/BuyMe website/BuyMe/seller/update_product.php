<?php

try {
	include_once '../db_conn.php';
	
	$product_id = $_POST['product_id'];
	$category_id = $_POST['category_id'];
	$product_name = $_POST['product_name'];
	$product_image = $_POST['product_image'];
	$product_desc = $_POST['product_desc'];
	$product_price_main = $_POST['product_price'];
	$product_price_cent = $_POST['product_price_cent'];
	$product_price = $product_price_main.".".$product_price_cent;
	
	if($product_image!="") {
		
		$query = "UPDATE product SET category_id='$category_id', product_name='$product_name', product_image='$product_image', product_desc='$product_desc', product_price='$product_price' WHERE product_id='$product_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
			
		echo "updated";
		
	} else {
		
		$query = "UPDATE product SET category_id='$category_id', product_name='$product_name', product_desc='$product_desc', product_price='$product_price' WHERE product_id='$product_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		echo "updated";
	}
	
} catch(PDOExeption $e) {
	
	echo "Error: ".$e->getMessage();
}


?>