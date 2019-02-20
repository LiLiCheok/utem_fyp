<?php

try {
	include_once '../db_conn.php';
	
	$product_id = $_POST['product_id'];
	
	$query = "SELECT p.*, c.category_name FROM product p, category c WHERE p.category_id=c.category_id AND p.product_id='$product_id'";
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