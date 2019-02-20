<?php 

try {
	
	include_once '../db_conn.php';
	
	$query="SELECT category_id, category_name FROM category";
	$stmt=$conn->prepare($query);
	$stmt->execute();
	$count_row = $stmt->rowCount();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if($count_row!=0) {
		
		echo json_encode($result);
		
	} else if($count_row==0) {
		
		echo "no_category";
	}

} catch(PDOExeption $e) {
	
	echo "Error: ".$e->getMessage();
}

?>