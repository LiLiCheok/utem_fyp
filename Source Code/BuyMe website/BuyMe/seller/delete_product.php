<?php

try {
	include_once '../db_conn.php';
	
	$product_id = $_POST['product_id'];
	
	if($product_id!="") {
		
		$query = "UPDATE product SET product_status='deleted' WHERE product_id='$product_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
			
		echo "deleted";
		
	} else {
		
		echo "missing";
	}
	
} catch(PDOExeption $e) {
	
	echo "Error: ".$e->getMessage();
}

?>