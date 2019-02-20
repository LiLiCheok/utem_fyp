<?php

try {

	include_once 'db_conn.php';
		
	$user_id = $_POST['user_id'];
	
	$query = "SELECT * FROM orders WHERE user_id = '$user_id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$row = $stmt->rowCount();
	if($row!=0) {
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($result);
	} else {
		echo "no_order";
	}
	
} catch(PDOException $e) {
	
	echo "Error: " . $e->getMessage();
}

?>