<?php

try {
	
	include_once '../db_conn.php';
	
	$query = "SELECT COUNT(product_id) as num_product FROM product";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row) {
		$old_pid = $row['num_product'];
	}
	
	if($old_pid!=0||$old_pid==0) {
		$product_id = 'P'.sprintf("%019s", $old_pid+1);
		echo $product_id;
	}
	
} catch(PDOExeption $e) {
	
	echo "Error: ".$e->getMessage();
}

?>